<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Availability;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use App\Models\CancellationPolicy;
use App\Notifications\AdminPaymentReceived;
use App\Notifications\NewReservationAdmin;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Point d'entrée principal — redirige vers la réservation simplifiée
     */
    public function startBooking(Request $request)
    {
        return redirect()->route('booking.appointment');
    }

    /**
     * AJAX public : coiffeuses disponibles pour un service (sans filtre de date)
     */
    public function employeesByService(Request $request)
    {
        $request->validate(['service_id' => 'required|exists:services,id']);

        $employees = Employee::with(['user', 'reviews'])
            ->where('is_available', true)
            ->whereHas('services', fn($q) => $q->where('services.id', $request->service_id))
            ->get()
            ->map(fn($e) => [
                'id'        => $e->id,
                'name'      => $e->user->name ?? '',
                'specialty' => $e->specialty ?? '',
                'photo_url' => $e->photo_url,
                'rating'    => round($e->average_rating, 1),
            ]);

        return response()->json(['employees' => $employees]);
    }

    /**
     * AJAX public : créneaux disponibles pour une coiffeuse + date
     */
    public function availableSlotsPublic(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date'        => 'required|date|after_or_equal:today',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $slots    = $employee->getAvailableSlots($request->date);

        return response()->json(['slots' => $slots]);
    }

    /**
     * Prise de rendez-vous simplifiée : affiche uniquement le calendrier + créneaux
     */
    public function appointmentView(Request $request)
    {
        $employee = $request->filled('employee_id')
            ? Employee::with('user')->find((int) $request->employee_id)
            : null;

        $service = $request->filled('service_id')
            ? Service::find((int) $request->service_id)
            : null;

        $clients = (Auth::check() && Auth::user()->isAdmin())
            ? User::where('role', 'client')->orderBy('name')->get(['id', 'name', 'email'])
            : collect();

        return view('booking.appointment', compact('employee', 'service', 'clients'));
    }

    /**
     * AJAX public : créneaux généraux du salon pour une date donnée
     */
    public function appointmentSlotsForDate(Request $request)
    {
        $request->validate(['date' => 'required|date|after_or_equal:today']);

        $date = $request->date;

        // No slots on Sundays — salon is closed
        if (Carbon::parse($date)->dayOfWeek === Carbon::SUNDAY) {
            return response()->json(['slots' => []]);
        }

        $dayName = Carbon::parse($date)->locale('fr')->dayName; // ex. 'lundi'

        // Union des disponibilités de toutes les coiffeuses ce jour
        $availabilities = Availability::where('day_of_week', $dayName)
            ->where('is_active', true)
            ->get();

        $allSlots = [];

        if ($availabilities->isNotEmpty()) {
            // Créneaux basés sur les disponibilités configurées
            foreach ($availabilities as $avail) {
                $current = Carbon::parse($date . ' ' . $avail->start_time);
                $end     = Carbon::parse($date . ' ' . $avail->end_time);
                $step    = $avail->slot_duration ?? 30;

                while ($current->copy()->addMinutes($step)->lte($end)) {
                    $allSlots[] = $current->format('H:i');
                    $current->addMinutes($step);
                }
            }
        } else {
            // Aucune disponibilité configurée → planning général du salon (9h00 – 17h30)
            $current = Carbon::parse($date . ' 09:00');
            $end     = Carbon::parse($date . ' 17:30');

            while ($current->copy()->addMinutes(30)->lte($end)) {
                $allSlots[] = $current->format('H:i');
                $current->addMinutes(30);
            }
        }

        $allSlots = array_unique($allSlots);
        sort($allSlots);

        // Exclure les heures passées si c'est aujourd'hui
        if ($date === Carbon::today()->format('Y-m-d')) {
            $now      = Carbon::now();
            $allSlots = array_values(array_filter(
                $allSlots,
                fn($s) => Carbon::parse($date . ' ' . $s)->gt($now)
            ));
        }

        return response()->json(['slots' => array_values($allSlots)]);
    }

    /**
     * Enregistrer la réservation simplifiée
     */
    public function appointmentStore(Request $request)
    {
        $isAdmin = Auth::user()->isAdmin();

        $rules = [
            'date'        => 'required|date|after_or_equal:today',
            'start_time'  => 'required|date_format:H:i',
            'employee_id' => 'nullable|exists:employees,id',
            'service_id'  => 'nullable|exists:services,id',
            'notes'       => 'nullable|string|max:1000',
        ];
        if ($isAdmin) {
            $rules['client_id'] = 'nullable|exists:users,id';
        }

        $request->validate($rules);

        // L'admin peut créer pour n'importe quel client, sinon soi-même
        $clientId = ($isAdmin && $request->filled('client_id'))
            ? (int) $request->client_id
            : Auth::id();

        $startTime = Carbon::createFromFormat('H:i', $request->start_time);
        $endTime   = $startTime->copy()->addMinutes(30);

        $reservation = Reservation::create([
            'client_id'    => $clientId,
            'employee_id'  => $request->employee_id ?: null,
            'service_id'   => $request->service_id  ?: null,
            'salon_id'     => null,
            'date'         => $request->date,
            'start_time'   => $request->start_time,
            'end_time'     => $endTime->format('H:i'),
            'amount'       => 0,
            'status'       => $isAdmin ? 'confirmed' : 'pending',
            'client_notes' => $request->notes,
        ]);

        $msg = $isAdmin
            ? 'Réservation créée et confirmée avec succès.'
            : 'Votre rendez-vous est enregistré. Le salon vous confirmera très vite !';

        if (!$isAdmin) {
            $admins = User::role('admin')->get();
            \Illuminate\Support\Facades\Notification::send($admins, new NewReservationAdmin($reservation));
        }

        return redirect()->route('booking.appointment.confirmation', $reservation)
            ->with('success', $msg);
    }

    /**
     * Page de confirmation de la réservation simplifiée
     */
    public function appointmentConfirmation(Reservation $reservation)
    {
        // L'admin peut voir toutes les confirmations, le client uniquement les siennes
        if (!Auth::user()->isAdmin() && $reservation->client_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['employee.user', 'service', 'client']);

        return view('booking.appointment-confirmation', compact('reservation'));
    }

    /**
     * Étape 1: Sélection du service
     */
    public function selectService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id'
        ]);

        $service = Service::with('categorie', 'salon')->findOrFail($request->service_id);

        // Stocker en session
        session(['booking.service' => $service]);

        // Récupérer les employés DISPONIBLES pour ce service spécifique
        $employees = Employee::whereHas('services', function($query) use ($service) {
            $query->where('services.id', $service->id);
        })
        ->where('is_available', true)
        ->with(['services', 'salon', 'user', 'reviews'])
        ->get();

        // Si le client vient du profil d'une coiffeuse, filtrer sur elle seule
        $preselectedId = session('booking.preselected_employee_id');
        if ($preselectedId) {
            $filtered = $employees->filter(fn($emp) => $emp->id === $preselectedId)->values();
            // Garder le filtre seulement si elle propose bien ce service
            if ($filtered->isNotEmpty()) {
                $employees = $filtered;
            }
            session()->forget('booking.preselected_employee_id');
        }

        return view('booking.step2-employee', compact('service', 'employees'));
    }

    /**
     * Étape 2: Sélection de l'employé
     */
    public function selectEmployee(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id'
        ]);

        $service = session('booking.service');
        $employee = Employee::findOrFail($request->employee_id);

        // Stocker en session
        session(['booking.employee' => $employee]);

        // Générer les créneaux disponibles pour les 7 prochains jours
        $availableSlots = $this->getAvailableSlots($employee, $service);

        return view('booking.step3-datetime', compact('service', 'employee', 'availableSlots'));
    }

    /**
     * Réservation rapide : depuis le profil coiffeuse → étape 3 directement
     */
    public function quickBooking(Request $request)
    {
        $preServiceId  = $request->input('service_id');
        $preEmployeeId = $request->input('employee_id');

        // Service + employé fournis (depuis profil coiffeuse) → sauter étapes 1 & 2
        if ($preServiceId && $preEmployeeId) {
            $service  = Service::with('categorie', 'salon')
                ->where('is_active', true)
                ->find((int) $preServiceId);
            $employee = Employee::with(['services', 'salon', 'user'])
                ->find((int) $preEmployeeId);

            if ($service && $employee) {
                session([
                    'booking.service'  => $service,
                    'booking.employee' => $employee,
                ]);

                $availableSlots = $this->getAvailableSlots($employee, $service);

                return view('booking.step3-datetime', compact('service', 'employee', 'availableSlots'));
            }
        }

        // Accès direct sans contexte → page quick classique
        $services = Service::with('categorie')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('booking.quick', compact('services', 'preServiceId', 'preEmployeeId'));
    }

    /**
     * Soumission de la réservation rapide (auth requise)
     */
    public function quickStore(Request $request)
    {
        $request->validate([
            'service_id'          => 'required|exists:services,id',
            'employee_id'         => 'required|exists:employees,id',
            'date'                => 'required|date|after_or_equal:today',
            'start_time'          => 'required|date_format:H:i',
            'model_description'   => 'nullable|string|max:1000',
            'current_hair_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'desired_style_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $service  = Service::with('categorie', 'salon')->findOrFail($request->service_id);
        $employee = Employee::findOrFail($request->employee_id);

        session([
            'booking.service'  => $service,
            'booking.employee' => $employee,
        ]);

        return $this->selectDateTime($request);
    }

    /**
     * Étape 3: Sélection date/heure
     */
    public function selectDateTime(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'current_hair_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'desired_style_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'model_description' => 'nullable|string|max:1000',
        ]);

        $service = session('booking.service');
        $employee = session('booking.employee');

        // Calculer l'heure de fin
        $startTime = Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $reservationData = [
            'client_id' => Auth::id(),
            'service_id' => $service->id,
            'employee_id' => $employee->id,
            'salon_id' => $service->salon_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $endTime->format('H:i'),
            'amount' => $service->price,
            'status' => 'pending',
            'client_notes' => $request->model_description ?? null,
        ];

        if ($request->hasFile('current_hair_image')) {
            $reservationData['current_hair_image'] = $request->file('current_hair_image')->store('client_hair', 'public');
        }

        if ($request->hasFile('desired_style_image')) {
            $reservationData['desired_style_image'] = $request->file('desired_style_image')->store('desired_styles', 'public');
        }

        $reservation = Reservation::create($reservationData);

        $admins = User::role('admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new NewReservationAdmin($reservation));

        // Stocker l'ID de réservation en session
        session(['booking.reservation_id' => $reservation->id]);

        return redirect()->route('booking.payment', $reservation);
    }

    /**
     * Étape 4: Afficher le paiement
     */
    public function showPayment(Reservation $reservation)
    {
        // Vérifier que c'est bien la réservation de l'utilisateur
        if ($reservation->client_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['service', 'employee.user']);

        $service = $reservation->service;
        $depositAmount = $this->calculateDeposit($service->price);

        return view('booking.step4-payment', compact('reservation', 'service', 'depositAmount'));
    }

    /**
     * Confirmer la réservation et traiter le paiement
     */
    public function confirmBooking(Request $request)
    {
        Log::info('confirmBooking called', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'payment_method' => 'required|in:card,paypal,mobile_money,cash',
            'deposit_percentage' => 'required|in:50,70,100',
            'card_holder' => 'required_if:payment_method,card|max:255',
            'card_number' => 'required_if:payment_method,card',
            'card_expiry' => 'required_if:payment_method,card',
            'card_cvv' => 'required_if:payment_method,card',
            'card_phone' => 'required_if:payment_method,card',
            'paypal_email' => 'required_if:payment_method,paypal',
            'mobile_phone' => 'required_if:payment_method,mobile_money',
            'mobile_network' => 'nullable|required_if:payment_method,mobile_money|in:orange_money,mtn_money,wave,orange-money,mtn-money',
            'terms_conditions' => 'accepted',
            'terms_delays' => 'accepted',
            'terms_refunds' => 'accepted',
            'payment_notes' => 'nullable|string|max:500',
            'cash_name' => 'nullable|string|max:255',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf|max:4096',
        ], [
            'reservation_id.required' => 'La réservation est requise.',
            'reservation_id.exists' => 'La réservation est invalide.',
            'payment_method.required' => 'La méthode de paiement est requise.',
            'payment_method.in' => 'La méthode de paiement sélectionnée n’est pas valide.',
            'deposit_percentage.in' => 'Le pourcentage d’acompte sélectionné n’est pas valide.',
            'card_holder.required_if' => 'Le nom du titulaire est requis pour le paiement par carte.',
            'card_number.required_if' => 'Le numéro de carte est requis pour le paiement par carte.',
            'card_expiry.required_if' => 'La date d’expiration est requise pour le paiement par carte.',
            'card_cvv.required_if' => 'Le CVV est requis pour le paiement par carte.',
            'card_phone.required_if' => 'Le téléphone est requis pour le paiement par carte.',
            'paypal_email.required_if' => 'L’email PayPal est requis pour le paiement PayPal.',
            'mobile_phone.required_if' => 'Le téléphone Mobile Money est requis pour le paiement Mobile Money.',
            'mobile_network.required_if' => 'L’opérateur Mobile Money est requis pour le paiement Mobile Money.',
            'mobile_network.in' => 'L’opérateur Mobile Money sélectionné n’est pas valide.',
            'mobile_network.max' => 'L’opérateur Mobile Money ne doit pas dépasser :max caractères.',
            'terms_conditions.accepted' => 'Veuillez accepter les conditions générales.',
            'terms_delays.accepted' => 'Veuillez accepter les règles de retard.',
            'terms_refunds.accepted' => 'Veuillez accepter la politique de remboursement.',
            'payment_proof.required_if' => 'Une preuve de paiement est requise pour le paiement sur place.',
            'payment_proof.file' => 'La preuve de paiement doit être un fichier valide.',
            'payment_proof.mimes' => 'La preuve de paiement doit être au format jpg, jpeg, png, gif, webp ou pdf.',
            'payment_proof.max' => 'La preuve de paiement ne doit pas dépasser 4 Mo.',
        ], [
            'payment_method' => 'méthode de paiement',
            'deposit_percentage' => 'pourcentage d’acompte',
            'card_holder' => 'nom du titulaire',
            'card_number' => 'numéro de carte',
            'card_expiry' => 'date d’expiration',
            'card_cvv' => 'CVV',
            'card_phone' => 'téléphone',
            'paypal_email' => 'email PayPal',
            'mobile_phone' => 'téléphone Mobile Money',
            'mobile_network' => 'opérateur Mobile Money',
            'terms_conditions' => 'conditions générales',
            'terms_delays' => 'règles de retard',
            'terms_refunds' => 'politique de remboursement',
            'payment_proof' => 'preuve de paiement',
            'cash_name' => 'nom du payeur',
        ]);
        // 
        //     'reservation_id.required' => 'La réservation est requise.',
        //     'reservation_id.exists' => 'La réservation est invalide.',
        //     'payment_method.required' => 'La méthode de paiement est requise.',
        //     'payment_method.in' => 'La méthode de paiement sélectionnée n’est pas valide.',
        //     'deposit_percentage.in' => 'Le pourcentage d’acompte sélectionné n’est pas valide.',
        //     'card_holder.required_if' => 'Le nom du titulaire est requis pour le paiement par carte.',
        //     'card_number.required_if' => 'Le numéro de carte est requis pour le paiement par carte.',
        //     'card_expiry.required_if' => 'La date d’expiration est requise pour le paiement par carte.',
        //     'card_cvv.required_if' => 'Le CVV est requis pour le paiement par carte.',
        //     'card_phone.required_if' => 'Le téléphone est requis pour le paiement par carte.',
        //     'paypal_email.required_if' => 'L’email PayPal est requis pour le paiement PayPal.',
        //     'mobile_phone.required_if' => 'Le téléphone Mobile Money est requis pour le paiement Mobile Money.',
        //     'mobile_network.required_if' => 'L’opérateur Mobile Money est requis pour le paiement Mobile Money.',
        //     'mobile_network.in' => 'L’opérateur Mobile Money sélectionné n’est pas valide.',
        //     'mobile_network.max' => 'L’opérateur Mobile Money ne doit pas dépasser :max caractères.',
        //     'terms_accepted.accepted' => 'Veuillez accepter les conditions générales pour confirmer votre réservation.',
        //     'payment_proof.required_if' => 'Une preuve de paiement est requise pour le paiement sur place.',
        //     'payment_proof.file' => 'La preuve de paiement doit être un fichier valide.',
        //     'payment_proof.mimes' => 'La preuve de paiement doit être au format jpg, jpeg, png, gif, webp ou pdf.',
        //     'payment_proof.max' => 'La preuve de paiement ne doit pas dépasser 4 Mo.',
        // ], [
        //     'payment_method' => 'méthode de paiement',
        //     'deposit_percentage' => 'pourcentage d’acompte',
        //     'card_holder' => 'nom du titulaire',
        //     'card_number' => 'numéro de carte',
        //     'card_expiry' => 'date d’expiration',
        //     'card_cvv' => 'CVV',
        //     'card_phone' => 'téléphone',
        //     'paypal_email' => 'email PayPal',
        //     'mobile_phone' => 'téléphone Mobile Money',
        //     'mobile_network' => 'opérateur Mobile Money',
        //     'terms_accepted' => 'conditions générales',
        //     'payment_proof' => 'preuve de paiement',
        //     'cash_name' => 'nom du payeur',
        // ]);

        Log::info('Validation passed for confirmBooking', [
            'reservation_id' => $request->reservation_id,
            'payment_method' => $request->payment_method
        ]);

        $reservationId = $request->input('reservation_id', session('booking.reservation_id'));
        if (!$reservationId) {
            return redirect()->route('booking.start')->with('error', 'Session expirée. Veuillez recommencer.');
        }

        $reservation = Reservation::findOrFail($reservationId);
        if ($reservation->client_id !== Auth::id()) {
            abort(403);
        }

        // Calculer le montant de l'acompte
        $depositAmount = ($reservation->amount * $request->deposit_percentage) / 100;

        // Mapper la méthode de paiement aux valeurs de la base de données
        $paymentMethod = $this->mapPaymentMethod(
            $request->payment_method,
            str_replace('-', '_', $request->mobile_network ?? 'wave')
        );

        $paymentData = [
            'reservation_id' => $reservation->id,
            'client_id' => $reservation->client_id,
            'amount' => $depositAmount,
            'method' => $paymentMethod,
            'status' => 'pending',
            'transaction_id' => null,
        ];

        $reservation->update([
            'terms_conditions' => true,
            'terms_delays' => true,
            'terms_refunds' => true,
            'terms_signed_at' => now(),
        ]);

        if ($request->payment_method === 'card') {
            $paymentData['gateway_response'] = [
                'card_holder' => $request->card_holder,
                'source' => 'stripe_checkout',
                'phone' => $request->card_phone,
            ];
        }

        if ($request->payment_method === 'paypal') {
            $paymentData['gateway_response'] = [
                'paypal_email' => $request->paypal_email,
            ];
        }

        if ($request->payment_method === 'mobile_money') {
            $paymentData['phone_number'] = $request->mobile_phone;
            $paymentData['gateway_response'] = [
                'mobile_network' => $request->mobile_network,
                'phone' => $request->mobile_phone,
            ];
        }

        if ($request->payment_method === 'cash') {
            $paymentData['gateway_response'] = [
                'notes' => $request->payment_notes,
            ];
            $paymentData['cash_name'] = $request->cash_name;

            if ($request->hasFile('payment_proof') && $request->file('payment_proof')->isValid()) {
                $paymentData['proof_path'] = $request->file('payment_proof')
                    ->store('payment_proofs', 'public');
            }
        }

        $payment = Payment::create($paymentData);

        // Nettoyer la session
        session()->forget(['booking.service', 'booking.employee', 'booking.reservation_id']);

        if ($request->payment_method === 'card') {
            return redirect()->route('payment.stripe', $payment);
        }

        if ($request->payment_method === 'paypal') {
            return redirect()->route('payment.paypal', $payment);
        }

        if ($request->payment_method === 'mobile_money') {
            return redirect()->route('payment.mobile', $payment);
        }

        $message = match ($request->payment_method) {
            'cash' => 'Votre réservation est enregistrée. Le paiement sur place sera confirmé après vérification.',
            default => 'Votre réservation est enregistrée et en attente de paiement.',
        };

        return redirect()->route('booking.confirmation', $reservation)->with('success', $message);
    }

    /**
     * Afficher la page de confirmation de réservation
     */
    public function showConfirmation(Reservation $reservation)
    {
        // Vérifier que c'est le client qui accède à sa réservation
        if ($reservation->client_id !== Auth::id()) {
            abort(403);
        }

        // Récupérer le dernier paiement
        $payment = $reservation->payment()->latest()->first();

        if (!$payment) {
            return redirect()->route('client.reservations')->with('error', 
                'Aucun paiement trouvé pour cette réservation.'
            );
        }

        return view('booking.confirmation', compact('reservation', 'payment'));
    }

    /**
     * Mapper les méthodes de paiement du formulaire aux valeurs de la base de données
     */
    private function mapPaymentMethod(string $formMethod, ?string $mobileNetwork = null): string
    {
        return match($formMethod) {
            'card' => 'stripe',
            'paypal' => 'paypal',
            'mobile_money' => $mobileNetwork ?? 'wave',
            'cash' => 'cash',
            default => 'stripe'
        };
    }

    /**
     * Calculer les créneaux disponibles
     */
    private function getAvailableSlots(Employee $employee, Service $service)
    {
        $slots = [];
        $today = Carbon::today();

        // Générer pour les 7 prochains jours
        for ($day = 0; $day < 7; $day++) {
            $date = $today->copy()->addDays($day);
            $dayName = $this->getFrenchDayName($date->format('l'));

            // Récupérer les disponibilités de l'employé pour ce jour
            $availability = Availability::where('employee_id', $employee->id)
                ->where('day_of_week', $dayName)
                ->first();

Log::info("Checking availability for employee {$employee->id} on {$dayName}: " . ($availability ? 'found' : 'not found'));

            if ($availability && $availability->is_active) {
                $daySlots = $this->generateTimeSlots(
                    $availability->start_time,
                    $availability->end_time,
                    $service->duration,
                    $date,
                    $employee->id
                );

                if (!empty($daySlots)) {
                    $slots[$date->format('Y-m-d')] = [
                        'date' => $date,
                        'slots' => $daySlots
                    ];
                }
            }
        }

        Log::info('Generated slots for employee ' . $employee->id . ':', array_keys($slots));
        return $slots;
    }

    /**
     * Convertir le nom du jour anglais en français
     */
    private function getFrenchDayName(string $englishDay): string
    {
        $days = [
            'monday' => 'lundi',
            'tuesday' => 'mardi',
            'wednesday' => 'mercredi',
            'thursday' => 'jeudi',
            'friday' => 'vendredi',
            'saturday' => 'samedi',
            'sunday' => 'dimanche'
        ];

        return $days[strtolower($englishDay)] ?? $englishDay;
    }

    /**
     * Générer les créneaux horaires disponibles
     */
    private function generateTimeSlots($startTime, $endTime, $duration, $date, $employeeId)
    {
        $slots = [];
        $start = Carbon::createFromFormat('H:i:s', $startTime);
        $end = Carbon::createFromFormat('H:i:s', $endTime);

        while ($start->copy()->addMinutes($duration)->lessThanOrEqualTo($end)) {
            $slotEnd = $start->copy()->addMinutes($duration);

            // Vérifier si le créneau est disponible
            $isAvailable = !Reservation::where('employee_id', $employeeId)
                ->where('date', $date->format('Y-m-d'))
                ->where('status', '!=', 'cancelled')
                ->where(function($query) use ($start, $slotEnd) {
                    $query->whereBetween('start_time', [$start->format('H:i'), $slotEnd->format('H:i')])
                          ->orWhereBetween('end_time', [$start->format('H:i'), $slotEnd->format('H:i')])
                          ->orWhere(function($q) use ($start, $slotEnd) {
                              $q->where('start_time', '<=', $start->format('H:i'))
                                ->where('end_time', '>=', $slotEnd->format('H:i'));
                          });
                })->exists();

            if ($isAvailable) {
                $slots[] = [
                    'start' => $start->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                    'formatted' => $start->format('H:i') . ' - ' . $slotEnd->format('H:i')
                ];
            }

            $start->addMinutes(30); // Intervalle de 30 minutes entre créneaux
        }

        return $slots;
    }

    /**
     * Calculer le montant de l'acompte
     */
    private function calculateDeposit($totalAmount)
    {
        // Par défaut 50%, configurable
        return $totalAmount * 0.5;
    }
    /**
     * Liste des réservations (admin)
     */
    public function index()
    {
        $reservations = Reservation::with(['service', 'client'])
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $clients = User::where('role', 'client')->get();
        $services = Service::all();
        $employees = Employee::with('user')->get();

        return view('reservations.create', compact('clients', 'services', 'employees'));
    }

    /**
     * Formulaire de modification d'une réservation
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $clients     = User::where('role', 'client')->get();
        $services    = Service::where('is_active', true)->get();

        return view('reservations.edit', compact('reservation', 'clients', 'services'));
    }

    /**
     * Mettre à jour une réservation
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'service_id'       => 'required|exists:services,id',
            'date_reservation' => 'required|date',
            'heure_reservation'=> 'required',
            'status'           => 'required|in:pending,confirmed,done,cancelled',
        ]);

        $reservation->update([
            'client_id'  => $request->user_id,
            'service_id' => $request->service_id,
            'date'       => $request->date_reservation,
            'start_time' => $request->heure_reservation,
            'status'     => $request->status,
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation mise à jour avec succès.');
    }

    /**
     * Liste des réservations du client connecté
     */
    public function myBookings()
    {
        $reservations = Reservation::with(['service', 'employee.user', 'payment'])
            ->where('client_id', Auth::id())
            ->latest()
            ->get();

        return view('reservations.my-bookings', compact('reservations'));
    }

    /**
     * Enregistrer une réservation
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'status' => 'required|in:pending,confirmed,done,cancelled',
            'client_notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);
        $endTime = Carbon::createFromFormat('H:i', $request->start_time)
            ->addMinutes($service->duration)
            ->format('H:i');

        Reservation::create([
            'client_id' => $request->client_id,
            'service_id' => $service->id,
            'employee_id' => $request->employee_id,
            'salon_id' => $service->salon_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $endTime,
            'amount' => $service->price,
            'status' => $request->status,
            'client_notes' => $request->client_notes,
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation créée avec succès');
    }

    /**
     * Générer facture PDF
     */
    public function facture($id)
    {
        $reservation = Reservation::with(['client', 'service'])->findOrFail($id);

        $pdf = PDF::loadView('reservations.facture', compact('reservation'));

        return $pdf->download('facture-'.$id.'.pdf');
    }

    /**
     * Réservations employé
     */
    public function employeeBookings()
    {
        $employee = Auth::user()->employee;
        abort_unless($employee, 404);

        $reservations = Reservation::with(['client', 'service'])
            ->where('employee_id', $employee->id)
            ->latest()
            ->get();

        return view('employee.reservations', compact('reservations'));
    }

    /**
     * Réservations prestataire
     */
    public function prestataireBookings()
    {
        $reservations = Reservation::with('service')
            ->whereHas('service', function ($query) {
                $query->where('prestataire_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('prestataire.reservations', compact('reservations'));
    }
}