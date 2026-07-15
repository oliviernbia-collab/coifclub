<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use App\Notifications\ReservationConfirmed;
use App\Notifications\PaymentConfirmed;
use App\Notifications\AdminPaymentReceived;
use App\Services\ActivityLogger;

class PaymentController extends Controller
{
    // ── Paiement Mobile Money (Orange/MTN/Wave) ────────
    public function initiateMobile(Payment $payment)
    {
        $reservation = $payment->reservation;
        return view('payment.mobile', compact('payment', 'reservation'));
    }

    public function processMobile(Request $request, Payment $payment)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'regex:/^(?:\+225|0)\d{8,10}$/'],
        ], [
            'phone_number.regex' => 'Le numéro de téléphone doit être au format +225XXXXXXXX ou 0XXXXXXXX.',
        ]);

        $payment->update([
            'phone_number' => $request->phone_number,
            'status'       => 'processing',
        ]);

        if (!config('payment.cinetpay_key') || !config('payment.cinetpay_site_id')) {
            $payment->update(['status' => 'completed', 'paid_at' => now()]);
            $payment->reservation->confirm();
            return redirect()->route('booking.confirmation', $payment->reservation)
                ->with('success', 'Votre paiement Mobile Money a été enregistré et confirmé.');
        }

        try {
            // Exemple avec l'API CinetPay (populaire en Afrique de l'Ouest)
            $response = Http::post(config('payment.cinetpay_url') . '/payment', [
                'apikey'          => config('payment.cinetpay_key'),
                'site_id'         => config('payment.cinetpay_site_id'),
                'transaction_id'  => 'PAY-' . $payment->id . '-' . time(),
                'amount'          => $payment->amount,
                'currency'        => 'XOF',
                'description'     => 'Réservation ' . $payment->reservation->reference,
                'return_url'      => route('booking.confirmation', $payment->reservation),
                'notify_url'      => route('payment.webhook', $payment),
                'customer_name'   => Auth::user()->name,
                'customer_email'  => Auth::user()->email,
                'customer_phone_number' => $request->phone_number,
                'channels'        => strtoupper(str_replace('_', '-', $payment->method)),
            ]);

            if ($response->successful() && $response['code'] === '201') {
                $payment->update(['transaction_id' => $response['data']['transaction_id']]);
                return redirect($response['data']['payment_url']);
            }

            throw new \Exception($response['message'] ?? 'Erreur de paiement');

        } catch (\Exception $e) {
            Log::error('Paiement Mobile Money échoué', ['error' => $e->getMessage(), 'payment_id' => $payment->id]);
            $payment->update(['status' => 'failed']);
            return back()->with('error', 'Le paiement a échoué. Veuillez réessayer.');
        }
    }

    // ── Paiement Stripe ───────────────────────────────
    public function initiateStripe(Payment $payment)
    {
        $reservation = $payment->reservation;

        // Créer une session Stripe Checkout
        Stripe::setApiKey(config('payment.stripe_secret'));

        $lineItems = [[
            'price_data' => [
                'currency'     => 'xof',
                'unit_amount'  => $payment->amount,
                'product_data' => [
                    'name'        => $reservation->service->name,
                    'description' => 'Salon GlamCoiffure · ' . $reservation->date->format('d/m/Y') . ' à ' . $reservation->start_time,
                ],
            ],
            'quantity' => 1,
        ]];

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items'           => $lineItems,
                'mode'                 => 'payment',
                'success_url'          => route('payment.success', $payment),
                'cancel_url'           => route('payment.cancel', $payment),
                'metadata'             => ['payment_id' => $payment->id],
            ]);

            $payment->update(['transaction_id' => $session->id]);

            return redirect($session->url);

        } catch (\Exception $e) {
            Log::error('Stripe error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erreur Stripe. Veuillez réessayer.');
        }
    }

    // ── Paiement PayPal ──────────────────────────────
    public function showPayPal(Payment $payment)
    {
        $reservation = $payment->reservation;

        try {
            $order = $this->createPayPalOrder($payment);
            $payment->update([
                'transaction_id' => $order['id'],
                'gateway_response' => array_merge($payment->gateway_response ?? [], [
                    'paypal_order_id' => $order['id'],
                    'paypal_approval_url' => $order['approval_url'],
                ]),
            ]);

            return view('payment.paypal', compact('payment', 'reservation'))->with('approvalUrl', $order['approval_url']);
        } catch (\Exception $e) {
            Log::error('PayPal order creation failed', ['error' => $e->getMessage(), 'payment_id' => $payment->id]);
            return back()->with('error', 'Impossible de démarrer le paiement PayPal. Veuillez réessayer.');
        }
    }

    public function processPayPal(Request $request, Payment $payment)
    {
        $token = $request->query('token') ?: $payment->gateway_response['paypal_order_id'] ?? null;
        if (! $token) {
            return redirect()->route('payment.paypal', $payment)
                ->with('error', 'Aucun identifiant de commande PayPal trouvé.');
        }

        try {
            $capture = $this->capturePayPalOrder($token);
            $payment->update([
                'status' => 'completed',
                'gateway_response' => array_merge($payment->gateway_response ?? [], $capture),
                'paid_at' => now(),
            ]);

            if ($payment->reservation) {
                $payment->reservation->confirm();
            }

            try {
                if ($payment->reservation) {
                    $payment->reservation->client->notify(new ReservationConfirmed($payment->reservation));
                }
                $payment->reservation?->client->notify(new PaymentConfirmed($payment));

                $admins = User::where('role', 'admin')->get();
                if ($admins->isNotEmpty()) {
                    Notification::send($admins, new AdminPaymentReceived($payment));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send PayPal confirmation notifications', [
                    'payment_id' => $payment->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return redirect()->route('payment.success', $payment);
        } catch (\Exception $e) {
            Log::error('PayPal capture failed', ['error' => $e->getMessage(), 'payment_id' => $payment->id]);
            return redirect()->route('payment.paypal', $payment)
                ->with('error', 'Capture PayPal échouée. Veuillez réessayer.');
        }
    }

    private function createPayPalOrder(Payment $payment): array
    {
        $token = $this->getPayPalAccessToken();
        $currency = config('payment.paypal_currency', 'EUR');
        $amount = $this->convertToPayPalAmount($payment->amount);

        $response = Http::withToken($token)
            ->acceptJson()
            ->post(config('payment.paypal_base_url') . '/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'reference_id' => (string) $payment->id,
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => $amount,
                    ],
                    'description' => 'Réservation #' . $payment->reservation->reference,
                ]],
                'application_context' => [
                    'return_url' => route('payment.paypal.capture', $payment),
                    'cancel_url' => route('payment.cancel', $payment),
                ],
            ]);

        if (! $response->successful()) {
            throw new \Exception($response->body());
        }

        $data = $response->json();
        $approvalLink = collect($data['links'] ?? [])->firstWhere('rel', 'approve')['href'] ?? null;

        if (! $approvalLink) {
            throw new \Exception('PayPal approval URL not found');
        }

        return [
            'id' => $data['id'],
            'approval_url' => $approvalLink,
        ];
    }

    private function capturePayPalOrder(string $orderId): array
    {
        $token = $this->getPayPalAccessToken();

        $response = Http::withToken($token)
            ->acceptJson()
            ->post(config('payment.paypal_base_url') . "/v2/checkout/orders/{$orderId}/capture");

        if (! $response->successful()) {
            throw new \Exception($response->body());
        }

        return $response->json();
    }

    private function getPayPalAccessToken(): string
    {
        $clientId = config('payment.paypal_client_id');
        $secret = config('payment.paypal_secret');

        if (! $clientId || ! $secret) {
            throw new \Exception('PayPal credentials are not configured.');
        }

        $response = Http::asForm()
            ->withBasicAuth($clientId, $secret)
            ->acceptJson()
            ->post(config('payment.paypal_base_url') . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (! $response->successful()) {
            throw new \Exception($response->body());
        }

        return $response->json()['access_token'];
    }

    private function convertToPayPalAmount($amount): string
    {
        $rate = config('payment.paypal_conversion_rate', 0.0015);
        $converted = (float) $amount * (float) $rate;
        return number_format($converted, 2, '.', '');
    }

    // ── Webhook de confirmation ───────────────────────
    public function webhook(Request $request, Payment $payment)
    {
        $payload = $request->all();
        Log::info('Payment webhook received', $payload);

        $payment->update([
            'gateway_response' => $payload,
            'status'           => $payload['status'] === 'ACCEPTED' ? 'completed' : 'failed',
            'paid_at'          => now(),
        ]);

        if ($payment->isCompleted() && $payment->reservation) {
            $payment->reservation->confirm();
            // NotificationService::sendConfirmation($payment->reservation);
        }

        return response()->json(['status' => 'ok']);
    }

    // ── Succès / Annulation ───────────────────────────
    public function success(Payment $payment)
    {
        $payment->update(['status' => 'completed', 'paid_at' => now()]);

        ActivityLogger::log('payment', "Paiement #{$payment->id} de {$payment->amount} $ confirmé (méthode : {$payment->method})", $payment);

        $payment->reservation->confirm();

        // Envoyer les notifications de confirmation
        try {
            $payment->reservation->client->notify(new ReservationConfirmed($payment->reservation));
            $payment->reservation->client->notify(new PaymentConfirmed($payment));

            $admins = User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new AdminPaymentReceived($payment));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send confirmation notifications', [
                'reservation_id' => $payment->reservation->id,
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
        }

        return view('payment.success', compact('payment'));
    }

    public function cancel(Payment $payment)
    {
        $payment->update(['status' => 'failed']);

        $payment->reservation->cancel('Paiement annulé.');

        return redirect()->route('client.book')
            ->with('error', 'Paiement annulé. Votre réservation n\'a pas été confirmée.');
    }
}
