<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Employee;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Availability;
use App\Models\Reservation;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /* ─────────────────────────────────────────────
       👨‍💼 ADMIN : LIST EMPLOYEES
    ───────────────────────────────────────────── */

    public function index()
    {
        $employees = User::where('role', 'employee')
            ->with('employee')
            ->latest()
            ->paginate(10);

        return view('admin.employees.index', compact('employees'));
    }

    /* ─────────────────────────────────────────────
       👨‍💼 ADMIN : CREATE EMPLOYEE
    ───────────────────────────────────────────── */

    public function create()
    {
        $salons   = Salon::all();
        $services = Service::where('is_active', true)->get();

        return view('admin.employees.create', compact('salons', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'nullable|string',
            'photo'     => 'nullable|image|mimes:jpeg,png,webp|max:5120',
            'salon_id'  => 'nullable|exists:salons,id',
            'specialty' => 'nullable|string',
            'bio'       => 'nullable|string',
            'password'  => 'required|string|min:8|confirmed',
            'services'  => 'nullable|array',
            'services.*'=> 'exists:services,id',
        ]);

        // Créer le user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'employee',
        ]);

        // Données employee
        $employeeData = [
            'phone'     => $request->phone,
            'salon_id'  => $request->salon_id,
            'specialty' => $request->specialty,
            'bio'       => $request->bio,
        ];

        // Photo dans employees, pas dans users
        if ($request->hasFile('photo')) {
            $employeeData['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $employee = $user->employee()->create($employeeData);

        // Services
        if ($request->has('services')) {
            $employee->services()->sync($request->services);
        }

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employé créé avec succès.');
    }

    /* ─────────────────────────────────────────────
       👨‍💼 ADMIN : EDIT EMPLOYEE
    ───────────────────────────────────────────── */

    public function edit($id)
    {
        $employee = User::with('employee.services')->findOrFail($id);
        $salons   = Salon::all();
        $services = Service::where('is_active', true)->get();

        return view('admin.employees.edit', compact('employee', 'salons', 'services'));
    }

    /* ─────────────────────────────────────────────
       👨‍💼 ADMIN : UPDATE EMPLOYEE
    ───────────────────────────────────────────── */

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $id,
            'phone'     => 'nullable|string',
            'photo'     => 'nullable|image|mimes:jpeg,png,webp|max:5120',
            'salon_id'  => 'nullable|exists:salons,id',
            'specialty' => 'required|string',
            'bio'       => 'nullable|string',
            'password'  => 'nullable|string|min:8|confirmed',
            'services'  => 'nullable|array',
            'services.*'=> 'exists:services,id',
        ]);

        // Mettre à jour la table users
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Mettre à jour la table employees
        $employeeData = [
            'phone'     => $request->phone,
            'salon_id'  => $request->salon_id,
            'specialty' => $request->specialty,
            'bio'       => $request->bio,
        ];

        // Photo dans employees, pas dans users
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->employee?->photo) {
                Storage::disk('public')->delete($user->employee->photo);
            }
            $employeeData['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $user->employee()->updateOrCreate(
            ['user_id' => $user->id],
            $employeeData
        );

        // Rafraîchir la relation après updateOrCreate
        $user->refresh();

        // Services
        if ($request->has('services')) {
            $user->employee->services()->sync($request->services);
        } else {
            $user->employee->services()->sync([]);
        }

        // Mot de passe
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employé mis à jour avec succès.');
    }

    /* ─────────────────────────────────────────────
       👨‍💼 ADMIN : DELETE EMPLOYEE
    ───────────────────────────────────────────── */

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Supprimer la photo si elle existe
        if ($user->employee?->photo) {
            Storage::disk('public')->delete($user->employee->photo);
        }

        $user->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employé supprimé avec succès.');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $employee = $user->employee;

        abort_unless($employee, 404);

        $today = now()->startOfDay();
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $activeStatuses = ['pending', 'confirmed', 'in_progress', 'done'];

        $baseQuery = Reservation::with(['client', 'service'])
            ->where('employee_id', $employee->id)
            ->whereIn('status', $activeStatuses);

        $todayCount = (clone $baseQuery)
            ->whereDate('date', $today)
            ->count();

        $todayReservations = (clone $baseQuery)
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get();

        $weekCount = (clone $baseQuery)
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->count();

        $clientsCount = (clone $baseQuery)
            ->distinct('client_id')
            ->count('client_id');

        $revenue = (clone $baseQuery)
            ->whereIn('status', ['confirmed', 'done'])
            ->sum('amount');

        $upcomingReservations = (clone $baseQuery)
            ->whereDate('date', '>=', $today)
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        $nextReservation = $upcomingReservations->first();

        $recentClients = (clone $baseQuery)
            ->latest('created_at')
            ->get()
            ->pluck('client')
            ->unique('id')
            ->take(5);

        $services = $employee->services()->withCount(['reservations as bookings_count' => function ($query) use ($employee) {
            $query->where('employee_id', $employee->id)
                  ->whereIn('status', ['pending', 'confirmed', 'in_progress', 'done']);
        }])->get();

        $availabilities = $employee->availabilities()->orderByRaw("FIELD(day_of_week, 'lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche')")->get();

        $stats = [
            'today' => $todayCount,
            'this_week' => $weekCount,
            'clients' => $clientsCount,
            'revenue' => number_format($revenue, 0, ',', ' '),
        ];

        return view('employee.dashboard', compact(
            'employee',
            'stats',
            'todayReservations',
            'upcomingReservations',
            'nextReservation',
            'recentClients',
            'services',
            'availabilities'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        $employee = $user->employee; // si tu as une relation employee

        return view('employee.profile', compact('user', 'employee'));
    }

    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $employee = $user->employee;

        if (! $employee) {
            abort(404, 'Profil employé introuvable.');
        }

        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'nullable|string|max:50',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'specialty' => 'nullable|string|max:255',
            'bio'       => 'nullable|string|max:2000',
            'password'  => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        $employeeData = [
            'specialty' => $request->specialty,
            'bio'       => $request->bio,
        ];

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }

            $employeeData['photo'] = $request->file('photo')->store('employees', 'public');
        }

        $employee->update($employeeData);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('employee.profile')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    public function availability()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            abort(404, 'Profil employé introuvable.');
        }

        $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        $availabilities = $employee->availabilities()->get()->keyBy('day_of_week');

        return view('employee.availability', compact('days', 'availabilities'));
    }

    public function saveAvailability(Request $request)
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            abort(404, 'Profil employé introuvable.');
        }

        $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

        $rules = [
            'days' => 'required|array',
        ];

        foreach ($days as $day) {
            $rules["days.$day.active"] = 'required|in:0,1';
            $rules["days.$day.start"] = [
                'exclude_if:days.' . $day . '.active,0',
                'required_if:days.' . $day . '.active,1',
                'regex:/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/'
            ];
            $rules["days.$day.end"] = [
                'exclude_if:days.' . $day . '.active,0',
                'required_if:days.' . $day . '.active,1',
                'regex:/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/'
            ];
            $rules["days.$day.slot"] = 'exclude_if:days.' . $day . '.active,0|required_if:days.' . $day . '.active,1|integer|in:30,45,60,90,120';
        }

        $validated = $request->validate($rules);

        foreach ($days as $day) {
            $data = $request->input("days.$day", []);
            $isActive = isset($data['active']) && $data['active'] == '1';

            if ($isActive && (empty($data['start']) || empty($data['end']))) {
                return back()->withErrors(["days.$day.start" => 'Les heures d\'ouverture doivent être renseignées pour les jours actifs.'])->withInput();
            }

            $employee->availabilities()->updateOrCreate(
                ['day_of_week' => $day],
                [
                    'is_active'     => $isActive,
                    'start_time'    => $data['start'] ?? '08:00',
                    'end_time'      => $data['end'] ?? '18:00',
                    'slot_duration' => $data['slot'] ?? 30,
                ]
            );
        }

        return redirect()->route('employee.availability')
            ->with('success', 'Disponibilités mises à jour avec succès.');
    }

    /* ─────────────────────────────────────────────
       👨‍💼 EMPLOYEE : COMPLETE RESERVATION
    ───────────────────────────────────────────── */

    public function completeReservation(Reservation $reservation)
    {
        // Vérifier que l'employé peut marquer cette réservation comme terminée
        if ($reservation->employee_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas marquer cette réservation comme terminée.');
        }

        if ($reservation->status !== 'confirmed') {
            return back()->with('error', 'Seules les réservations confirmées peuvent être marquées comme terminées.');
        }

        // Marquer comme terminée
        $reservation->markDone();

        // Attribuer des points de fidélité
        \App\Services\LoyaltyService::awardPointsForReservation($reservation);

        return back()->with('success', 'Réservation marquée comme terminée. Points de fidélité attribués.');
    }
}