<?php

namespace App\Http\Controllers;

use App\Models\{Reservation, Service, Employee, Payment};
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ── Étape 1 : Afficher le formulaire de réservation ──
    public function create()
    {
        $services  = Service::where('is_active', true)->orderBy('sort_order')->get();
        $employees = Employee::with('user')->where('is_available', true)->get();

        return view('client.book', compact('services', 'employees'));
    }

    // ── AJAX : créneaux disponibles pour employée + date ──
    public function availableSlots(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date'        => 'required|date|after_or_equal:today',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $slots    = $employee->getAvailableSlots($request->date);

        return response()->json(['slots' => $slots]);
    }

    // ── AJAX : employées disponibles pour un service + date ──
    public function availableEmployees(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date'       => 'required|date|after_or_equal:today',
        ]);

        $dayName = Carbon::parse($request->date)->locale('fr')->dayName;

        $employees = Employee::with(['user', 'availabilities'])
            ->where('is_available', true)
            ->whereHas('services', fn($q) => $q->where('service_id', $request->service_id))
            ->whereHas('availabilities', fn($q) => $q->where('day_of_week', $dayName)->where('is_active', true))
            ->get()
            ->map(function ($e) use ($request) {
                return [
                    'id'        => $e->id,
                    'name'      => $e->user->name,
                    'specialty' => $e->specialty,
                    'photo_url' => $e->photo_url,
                    'rating'    => round($e->average_rating, 1),
                    'slots'     => $e->getAvailableSlots($request->date),
                ];
            });

        return response()->json(['employees' => $employees]);
    }

    // ── Étape finale : Créer la réservation ──────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'   => 'required|exists:services,id',
            'employee_id'  => 'required|exists:employees,id',
            'date'         => 'required|date|after_or_equal:today',
            'time'         => 'required|date_format:H:i',
            'payment_method' => 'required|in:orange_money,mtn_money,wave,stripe',
            'phone_number' => 'nullable|string',
            'notes'        => 'nullable|string|max:500',
        ]);

        $service  = Service::findOrFail($validated['service_id']);
        $employee = Employee::findOrFail($validated['employee_id']);

        // Vérifier que le créneau est toujours libre
        $conflict = Reservation::where('employee_id', $employee->id)
            ->where('date', $validated['date'])
            ->where('start_time', $validated['time'])
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['time' => 'Ce créneau vient d\'être pris. Choisissez-en un autre.']);
        }

        $endTime = Carbon::parse($validated['date'] . ' ' . $validated['time'])
            ->addMinutes($service->duration)
            ->format('H:i');

        $reservation = Reservation::create([
            'client_id'    => auth()->id(),
            'service_id'   => $service->id,
            'employee_id'  => $employee->id,
            'salon_id'     => $service->salon_id,
            'date'         => $validated['date'],
            'start_time'   => $validated['time'],
            'end_time'     => $endTime,
            'amount'       => $service->price,
            'status'       => 'pending',
            'client_notes' => $validated['notes'] ?? null,
        ]);

        // Créer le paiement et initier la transaction
        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'client_id'      => auth()->id(),
            'amount'         => $service->price,
            'method'         => $validated['payment_method'],
            'phone_number'   => $validated['phone_number'],
            'status'         => 'pending',
        ]);

        ActivityLogger::log('create', "Réservation créée : {$service->name} le {$validated['date']} à {$validated['time']}", $reservation);

        // Rediriger vers le gateway de paiement selon la méthode
        return match($validated['payment_method']) {
            'orange_money', 'mtn_money', 'wave' => redirect()->route('payment.mobile', $payment),
            'stripe' => redirect()->route('payment.stripe', $payment),
            default  => redirect()->route('client.reservations')->with('success', 'Réservation créée !'),
        };
    }

    // ── Mes réservations (client) ─────────────────────
    public function myReservations()
    {
        $reservations = Reservation::with(['service', 'employee.user', 'payment'])
            ->where('client_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('client.reservations', compact('reservations'));
    }

    // ── Annuler une réservation (client) ──────────────
    public function cancel(Request $request, Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);
        abort_unless($reservation->isPending() || $reservation->isConfirmed(), 422, 'Cette réservation ne peut plus être annulée.');

        // Remboursement si déjà payé
        if ($reservation->payment?->isCompleted()) {
            // PaymentService::refund($reservation->payment);
        }

        $reservation->cancel($request->reason ?? 'Annulée par la cliente');

        ActivityLogger::log('cancel', "Réservation #{$reservation->id} annulée par le client", $reservation);

        return back()->with('success', 'Réservation annulée.');
    }

    // ── Laisser un avis ──────────────────────────────
    public function review(Request $request, Reservation $reservation)
    {
        abort_unless($reservation->client_id === auth()->id(), 403);
        abort_unless($reservation->isDone(), 422);
        abort_if($reservation->review()->exists(), 422, 'Vous avez déjà laissé un avis.');

        $validated = $request->validate([
            'rating'  => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);

        $reservation->review()->create([
            'client_id'   => auth()->id(),
            'employee_id' => $reservation->employee_id,
            'service_id'  => $reservation->service_id,
            ...$validated,
        ]);

        return back()->with('success', 'Merci pour votre avis !');
    }
}
