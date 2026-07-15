<?php

namespace App\Http\Controllers;

use App\Models\{
    Salon, Service, Employee, Reservation,
    Payment, User, Cancellation, Categorie, Promotion,
    Disponibilite, ContactMessage, ActivityLog
};
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminContactReply;
use App\Services\ActivityLogger;
use App\Notifications\ReservationStatusChanged;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    // ─────────────────────────────
    // 🔐 SALON SAFE
    // ─────────────────────────────
    private function getSalon()
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Utilisateur non authentifié.');
        }

        if ($user->role === 'admin') {
            return null; // admin global
        }

        $salon = $user->salon ?? null;

        if (!$salon) {
            abort(403, 'Salon introuvable pour cet utilisateur.');
        }

        return $salon;
    }

    // ─────────────────────────────
    // 📊 DASHBOARD
    // ─────────────────────────────
    public function dashboard()
    {
        $user = auth()->user();
        $salon = $this->getSalon();

        $baseReservationQuery = Reservation::when($salon, fn($q) => $q->where('salon_id', $salon->id));
        $basePaymentQuery = Payment::where('status', 'completed')
            ->when($salon, fn($q) => $q->whereHas('reservation', fn($q) => $q->where('salon_id', $salon?->id ?? null)));

        $totalReservations = $baseReservationQuery->count();
        $cancelledReservations = (clone $baseReservationQuery)
            ->where('status', 'cancelled')
            ->count();

        $topClients = User::where('role', 'client')
            ->withCount('reservationsAsClient')
            ->orderByDesc('reservations_as_client_count')
            ->take(5)
            ->get();

        $revenueByEmployee = Payment::where('status', 'completed')
            ->with(['reservation.employee.user'])
            ->when($salon, fn($q) => $q->whereHas('reservation', fn($q) => $q->where('salon_id', $salon->id)))
            ->get()
            ->groupBy(fn($payment) => $payment->reservation?->employee?->user?->name ?? 'Non assigné')
            ->map(fn($payments, $employee) => [
                'employee' => $employee,
                'revenue' => $payments->sum('amount'),
                'bookings' => $payments->count(),
            ])
            ->sortByDesc('revenue')
            ->values()
            ->take(5);

        $upcomingBirthdays = User::where('role', 'client')
            ->whereNotNull('birth_date')
            ->get()
            ->filter(function ($client) {
                $birthday = \Carbon\Carbon::parse($client->birth_date);
                $nextBirthday = $birthday->copy()->year(now()->year);
                if ($nextBirthday->isPast()) {
                    $nextBirthday->addYear();
                }
                return $nextBirthday->diffInDays(now()) <= 30;
            })
            ->count();

        $loyalClients = User::where('role', 'client')
            ->withCount('reservationsAsClient')
            ->having('reservations_as_client_count', '>=', 5)
            ->orderByDesc('reservations_as_client_count')
            ->take(5)
            ->get();

        $clientsWithAllergies = User::where('role', 'client')
            ->whereNotNull('allergies')
            ->where('allergies', '<>', '')
            ->count();

        $clientsWithPreferences = User::where('role', 'client')
            ->whereNotNull('preferences')
            ->where('preferences', '<>', '')
            ->count();

        $stats = [
            'total_clients' => User::where('role', 'client')->count(),
            'total_employees' => Employee::count(),
            'today_reservations' => Reservation::when($salon, fn($q) => $q->where('salon_id', $salon->id))
                ->whereDate('date', now())
                ->count(),
            'month_revenue' => $basePaymentQuery->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'total_revenue' => $basePaymentQuery->sum('amount'),
            'pending_reservations' => Reservation::when($salon, fn($q) => $q->where('salon_id', $salon->id))
                ->where('status', 'pending')
                ->count(),
            'pending_cancellations' => Cancellation::where('status', 'pending')
                ->when($salon, fn($q) => $q->whereHas('reservation', fn($q) => $q->where('salon_id', $salon->id)))
                ->count(),
            'cancel_rate' => $totalReservations ? round(($cancelledReservations / $totalReservations) * 100, 2) : 0,
            'refund_amount' => Cancellation::when($salon, fn($q) => $q->whereHas('reservation', fn($q) => $q->where('salon_id', $salon->id)))
                ->where('status', 'approved')
                ->sum('refund_amount'),
            'active_promotions' => Promotion::where('is_active', true)
                ->where('valid_from', '<=', now())
                ->where('valid_until', '>=', now())
                ->count(),
            'upcoming_birthdays' => $upcomingBirthdays,
            'loyal_clients' => $loyalClients->count(),
            'clients_with_allergies' => $clientsWithAllergies,
            'clients_with_preferences' => $clientsWithPreferences,
            'total_reservations' => $totalReservations,
        ];

        $revenueChart = collect(range(5, 0))->map(function ($i) use ($salon) {
            $date = now()->subMonths($i);

            $query = Payment::where('status', 'completed')
                ->when($salon, fn($q) => $q->whereHas('reservation', fn($q) => $q->where('salon_id', $salon->id)));

            return [
                'month' => $date->translatedFormat('F'),
                'revenue' => $query
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('amount'),
            ];
        });

        $recentReservations = Reservation::with(['client', 'service', 'employee'])
            ->when($salon, fn($q) => $q->where('salon_id', $salon->id))
            ->latest()
            ->take(10)
            ->get();

        $pendingReservations = Reservation::with(['client', 'service'])
            ->when($salon, fn($q) => $q->where('salon_id', $salon->id))
            ->where('status', 'pending')
            ->latest()
            ->take(6)
            ->get();

        $topServices = Service::withCount('reservations')
            ->when($salon, fn($q) => $q->where('salon_id', $salon->id))
            ->orderByDesc('reservations_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'revenueChart',
            'recentReservations',
            'pendingReservations',
            'topServices',
            'topClients',
            'revenueByEmployee',
            'loyalClients'
        ));
    }

    // ─────────────────────────────
    // 🧾 SERVICES
    // ─────────────────────────────
    public function services()
    {
        $salon = $this->getSalon();

        $query = Service::with(['categorie', 'reviews']);

        if ($salon) {
            $query->where('salon_id', $salon->id);
        }

        $services = $query->orderBy('sort_order')->paginate(20);
        $salons = Salon::orderBy('name')->get();

        return view('admin.services.index', compact('services', 'salon', 'salons'));
    }

    public function salons()
    {
        $salons = Salon::orderBy('name')->paginate(15);

        return view('admin.salons', compact('salons'));
    }

    public function destroySalon($id)
    {
        $salon = Salon::findOrFail($id);
        $salon->delete();

        return redirect()
            ->route('admin.salons')
            ->with('success', 'Salon supprimé avec succès.');
    }

    public function contacts(Request $request)
    {
        $status = $request->query('status');

        $contactsQuery = ContactMessage::latest();

        if ($status === 'answered') {
            $contactsQuery->whereNotNull('replied_at');
        } elseif ($status === 'unanswered') {
            $contactsQuery->whereNull('replied_at');
        }

        $contacts = $contactsQuery->paginate(20)->withQueryString();

        $totalContacts = ContactMessage::count();
        $todayContacts = ContactMessage::where('created_at', '>=', now()->startOfDay())->count();
        $unrepliedCount = ContactMessage::whereNull('replied_at')->count();
        $repliedCount = ContactMessage::whereNotNull('replied_at')->count();

        return view('admin.contacts', compact(
            'contacts',
            'status',
            'totalContacts',
            'todayContacts',
            'unrepliedCount',
            'repliedCount'
        ));
    }

    public function showContact(ContactMessage $contact)
    {
        return view('admin.contacts-show', compact('contact'));
    }

    public function replyContact(Request $request, ContactMessage $contact)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        Mail::to($contact->email)
            ->send(new AdminContactReply($contact, $request->input('reply')));

        $contact->update([
            'reply' => $request->input('reply'),
            'replied_at' => now(),
        ]);

        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'La réponse a bien été envoyée.');
    }

    // ✅ FIX PRINCIPAL ERREUR ICI (createSalon manquant)
    public function createSalon()
    {
        return view('admin.salons.create');
    }

    public function editSalon($id)
    {
        $salon = Salon::findOrFail($id);

        return view('admin.salons.edit', compact('salon'));
    }


    public function updateSalon(Request $request, $id)
{
    $salon = Salon::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:30',
        'city' => 'nullable|string|max:100',
        'address' => 'nullable|string|max:255',
    ]);

    $salon->update($validated);

    return redirect()
        ->route('admin.salons')
        ->with('success', 'Salon mis à jour avec succès.');
}

    public function updateSalonStatus(Request $request, Salon $salon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $salon->update($validated);

        return redirect()
            ->route('admin.infoSalon')
            ->with('success', 'Informations du salon mises à jour avec succès.');
    }

    // ─────────────────────────────
    // 🧾 SERVICES CREATE
    // ─────────────────────────────
    public function createService()
    {
        $salon = $this->getSalon();

        $categories = Categorie::all();
        $salons = Salon::orderBy('name')->get();
        $service = new Service();

        return view('admin.services.create', compact(
            'salon',
            'salons',
            'categories',
            'service'
        ));
    }

    public function editService(Service $service)
    {
        $salon = $this->getSalon();

        $categories = Categorie::all();
        $salons = Salon::orderBy('name')->get();

        return view('admin.services.edit', compact(
            'service',
            'salon',
            'salons',
            'categories'
        ));
    }

    public function showService(Service $service)
    {
        $salon = $this->getSalon();

        $service->load('categorie');

        return view('admin.services.show', compact(
            'service',
            'salon'
        ));
    }

    public function storeSalon(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:30',
        'city' => 'nullable|string|max:100',
        'address' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'logo' => 'nullable|image|max:2048',
    ]);

    // Gestion logo
    $logoPath = null;

    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('salons', 'public');
    }

    Salon::create([
        'name' => $validated['name'],
        'email' => $validated['email'] ?? null,
        'phone' => $validated['phone'] ?? null,
        'city' => $validated['city'] ?? null,
        'address' => $validated['address'] ?? null,
        'description' => $validated['description'] ?? null,
        'logo' => $logoPath,
        'owner_id' => auth()->id(),
    ]);

    return redirect()
        ->route('admin.salons')
        ->with('success', 'Salon créé avec succès.');
}

    public function storeService(Request $request)
    {
        $salon = $this->getSalon();

        $rules = [
            'name' => 'required|string|max:100',
            'categorie_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:15',
            'emoji' => 'nullable|string|max:4',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ];

        if (!$salon) {
            $rules['salon_id'] = 'required|exists:salons,id';
        }

        $validated = $request->validate($rules);
        $validated['salon_id'] = $salon ? $salon->id : $validated['salon_id'];
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validated);

        return back()->with('success', 'Prestation ajoutée.');
    }

    // ─────────────────────────────
    // 🧾 CLIENTS
    // ─────────────────────────────
    public function clients()
    {
        $clients = User::where('role', 'client')
            ->withCount('reservationsAsClient')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.clients', compact('clients'));
    }

    public function printClient($id)
    {
        $client = User::findOrFail($id);
        $salon = $this->getSalon();

        return view('admin.clients-print', compact('client', 'salon'));
    }

    // ─────────────────────────────
    // 📆 RÉSERVATIONS
    // ─────────────────────────────
    public function reservations(Request $request)
    {
        $salon = $this->getSalon();

        $query = Reservation::with(['client', 'service', 'employee'])
            ->when($salon, fn($q) => $q->where('salon_id', $salon->id));

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('employee')) {
            $query->where('employee_id', $request->employee);
        }

        $reservations = $query->latest()->paginate(20)->withQueryString();
        $employees = Employee::with('user')->orderBy('id')->get();

        return view('admin.reservations', compact('reservations', 'employees', 'salon'));
    }

    // ─────────────────────────────
    // 💳 PAIEMENTS
    // ─────────────────────────────
    public function payments(Request $request)
    {
        $filter = $request->input('filter');

        $query = Payment::with('user');
        if ($filter === 'reservation') {
            $query->whereNotNull('reservation_id');
        }
        $payments = $query->latest()->paginate(20)->withQueryString();

        $completedStatuses = ['completed', 'paid', 'success'];
        $reservationAmount = Payment::whereNotNull('reservation_id')->whereIn('status', $completedStatuses)->sum('amount');

        return view('admin.payments.index', compact('payments', 'reservationAmount', 'filter'));
    }

    public function validatePayment(Payment $payment)
    {
        if ($payment->method !== 'cash' || $payment->status !== 'pending') {
            return back()->with('error', 'Ce paiement ne peut pas être validé.');
        }

        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
            'approved_at' => now(),
            'transaction_id' => $payment->transaction_id ?: 'CASH-' . time(),
        ]);

        ActivityLogger::log('payment', "Paiement #{$payment->id} de {$payment->amount} $ validé manuellement par l'admin", $payment);

        return back()->with('success', 'Paiement sur place validé avec succès.');
    }

    // ─────────────────────────────
    // 📅 CALENDRIER
    // ─────────────────────────────
    public function calendar()
    {
        $today = now();
        $todayReservations = Reservation::whereDate('date', $today)->count();
        $availableSchedules = Disponibilite::where('jour', $today->locale('fr')->translatedFormat('l'))->count();
        $activeEmployees = Employee::where('is_available', true)->count() ?: Employee::count();
        $occupancyRate = $availableSchedules > 0
            ? min(100, round(($todayReservations / $availableSchedules) * 100))
            : 0;

        $nextReservation = Reservation::with(['client', 'service', 'employee.user', 'salon'])
            ->whereDate('date', '>=', $today)
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->first();

        return view('admin.calendar', compact(
            'today',
            'todayReservations',
            'availableSchedules',
            'activeEmployees',
            'occupancyRate',
            'nextReservation'
        ));
    }

    // ─────────────────────────────
    // 🏠 INFO SALON
    // ─────────────────────────────
    public function infoSalon()
    {
        $salon = Salon::first();

        return view('admin.info-salon', compact('salon'));
    }

    // ─────────────────────────────
    // 🕒 HEURES D’OUVERTURE
    // ─────────────────────────────
    public function openingHours(Request $request)
    {
        $salon = Salon::first();

        $weekOffset = (int) $request->get('week', 0);
        $weekStart  = now()->startOfWeek(\Carbon\Carbon::MONDAY)->addWeeks($weekOffset);
        $weekEnd    = $weekStart->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);

        $reservations = Reservation::with(['client', 'service', 'employee'])
            ->whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        // Group by date string for quick lookup in the view
        $reservationsByDate = $reservations->groupBy(fn($r) => $r->date->toDateString());

        return view('admin.heures-ouverture', compact('salon', 'weekStart', 'weekEnd', 'reservationsByDate', 'weekOffset'));
    }

    public function updateOpeningHours(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|string|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'status' => 'required|in:open,closed',
        ]);

        $salon = Salon::first();
        if (!$salon) {
            abort(404, 'Salon introuvable.');
        }

        $openingHours = $salon->opening_hours ?? [];
        $key = strtolower($validated['day']);

        $openingHours[$key] = [
            'open' => $validated['open_time'],
            'close' => $validated['close_time'],
            'status' => $validated['status'],
        ];

        $salon->opening_hours = $openingHours;
        $salon->save();

        return redirect()->route('admin.heuresOuverture')
            ->with('success', 'Horaires mis à jour pour ' . $validated['day'] . '.');
    }

    // ─────────────────────────────
    // 🎨 PERSONNALISATION
    // ─────────────────────────────
    public function customization()
    {
        $salon = Salon::first();
        return view('admin.personnalisation', compact('salon'));
    }

    public function updateBranding(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $salon = Salon::first() ?? abort(404, 'Salon not found');

        if ($request->hasFile('logo')) {
            if ($salon->logo) {
                Storage::disk('public')->delete($salon->logo);
            }
            $validated['logo'] = $request->file('logo')->store('salons', 'public');
        } else {
            unset($validated['logo']);
        }

        $salon->update($validated);

        return back()->with('success', 'Informations du salon mises à jour avec succès.');
    }

    // ─────────────────────────────
    // 📊 RAPPORTS
    // ─────────────────────────────
    public function reports()
    {
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $reservationCount = Reservation::count();
        $paymentCount = Payment::where('status', 'completed')->count();
        $topService = Service::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->first()?->name ?? 'Non disponible';
        $topClient = User::where('role', 'client')
            ->withCount('reservationsAsClient')
            ->orderByDesc('reservations_as_client_count')
            ->first()?->name ?? 'Non disponible';

        return view('admin.rapports', compact(
            'totalRevenue',
            'reservationCount',
            'paymentCount',
            'topService',
            'topClient'
        ));
    }

    // ─────────────────────────────
    // 📦 INVENTAIRE
    // ─────────────────────────────
    public function inventory()
    {
        $services = Service::with('categorie')
            ->orderBy('name')
            ->get()
            ->each(fn($service) => $service->category = $service->categorie?->nom);

        return view('admin.inventaire', compact('services'));
    }

   

    public function updateService(Request $request, $service)
    {
        $service = Service::findOrFail($service);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categorie_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'emoji' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable',
        ]);

        if ($request->hasFile('image')) {

            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $service->update($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service mis à jour avec succès.');
    }

    public function destroyService(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service supprimé avec succès.');
    }

    public function servicesIndex(Request $request)
    {
        $query = Service::latest();

        if ($request->filled('salon')) {
            $query->where('salon_id', $request->salon);
        }

        $services = $query->paginate(10)->withQueryString();
        $salons = Salon::all();

        return view('admin.services.index', compact('services', 'salons'));
    }

    public function editClient($id)
    {
        $client = \App\Models\User::findOrFail($id);

        return view('admin.clients-edit', compact('client'));
    }

    public function updateClient(\Illuminate\Http\Request $request, $id)
    {
        $client = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'role'  => 'nullable|string|max:50',
        ]);

        $client->update($validated);

        return redirect()
            ->route('admin.clients')
            ->with('success', 'Client mis à jour avec succès.');
    }

    public function confirmReservation($reservationId)
    {
        $reservation = \App\Models\Reservation::findOrFail($reservationId);

        // Vérifie si déjà confirmée
        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Cette réservation ne peut plus être confirmée.');
        }

        $reservation->update([
            'status' => 'confirmed',
        ]);

        ActivityLogger::log('confirm', "Réservation #{$reservation->id} confirmée par l'admin", $reservation);

        if ($reservation->client) {
            $reservation->client->notify(new ReservationStatusChanged($reservation));
        }

        return back()->with('success', 'Réservation confirmée avec succès.');
    }

    public function cancelReservation(Request $request, $reservation)
{
    $validated = $request->validate([
        'reason' => 'nullable|string|max:1000',
    ]);

    $reservation = \App\Models\Reservation::findOrFail($reservation);

    $reservation->update([
        'status' => 'cancelled',
        'cancel_reason' => $validated['reason'] ?? null,
    ]);

    ActivityLogger::log('cancel', "Réservation #{$reservation->id} annulée par l'admin", $reservation);

    if ($reservation->client) {
        $reservation->client->notify(new ReservationStatusChanged($reservation));
    }

    return redirect()->route('admin.reservations')
        ->with('success', 'Réservation annulée avec succès.');
}

    // ─────────────────────────────
    // 🔔 NOTIFICATIONS ADMIN
    // ─────────────────────────────
    public function adminNotifications()
    {
        $admin         = auth()->user();
        $notifications = $admin->notifications()->paginate(25);
        $unreadCount   = $admin->unreadNotifications()->count();

        return view('admin.notifications', compact('notifications', 'unreadCount'));
    }

    public function markAllAdminNotificationsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', __('messages.adm_notif_marked_read'));
    }

    // ─────────────────────────────
    // 📋 JOURNAL D'ACTIVITÉ
    // ─────────────────────────────
    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user')->latest('created_at');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->user . '%'));
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(30)->withQueryString();

        return view('admin.activity-logs', compact('logs'));
    }
}
