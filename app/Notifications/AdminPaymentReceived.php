<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminPaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $payment     = $this->payment;
        $reservation = $payment->reservation;

        return (new MailMessage)
            ->subject('Nouveau paiement reçu - Marol Hair Braiding')
            ->greeting('Bonjour ' . ($notifiable->name ?? 'Admin') . ',')
            ->line('Un nouveau paiement a été enregistré.')
            ->line('💰 Montant : $' . number_format($payment->amount, 2))
            ->line('📅 Date : ' . $payment->created_at->format('d/m/Y H:i'))
            ->line('Client : ' . ($reservation->client->name ?? 'N/A'))
            ->action('Voir les paiements', route('admin.payments'))
            ->salutation('L\'équipe Marol Hair Braiding');
    }

    public function toArray(object $notifiable): array
    {
        $payment     = $this->payment;
        $reservation = $payment->reservation;
        $client      = $reservation->client->name ?? 'Client';
        $service     = $reservation->service->name ?? 'Service';

        return [
            'icon'    => 'fa-solid fa-money-bill-wave',
            'color'   => '#4ade80',
            'title'   => 'Paiement reçu — $' . number_format($payment->amount, 2),
            'message' => $client . ' — ' . $service . '.',
            'link'    => route('admin.payments'),
        ];
    }
}
