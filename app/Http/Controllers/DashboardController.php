<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Address;
use App\Models\Favorite;

class DashboardController extends Controller
{

    public function index()
        {
            $role = auth()->user()->role;

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'employee' => redirect()->route('employee.dashboard'),
                'prestataire' => redirect()->route('prestataire.dashboard'),
                default => redirect()->route('client.dashboard'),
            };
        }

    // =========================
    // DASHBOARD PRESTATAIRE
    // =========================
    public function prestataire()
    {
        $user = Auth::user();

        $reservations = Reservation::with('service')
            ->whereHas('service', function ($q) use ($user) {
                $q->where('prestataire_id', $user->id);
            })
            ->latest()
            ->get();

        $totalReservations = $reservations->count();
        $enAttente = $reservations->where('status', 'en_attente')->count();
        $confirmees = $reservations->where('status', 'confirmee')->count();

        return view('prestataire.dashboard', compact(
            'reservations',
            'totalReservations',
            'enAttente',
            'confirmees'
        ));
    }

    public function client()
    {
        $userId = Auth::id();
        $user   = Auth::user();

        $totalReservations     = Reservation::where('client_id', $userId)->count();
        $pendingReservations   = Reservation::where('client_id', $userId)->where('status', 'pending')->count();
        $completedReservations = Reservation::where('client_id', $userId)->where('status', 'done')->count();
        $totalSpent            = Reservation::where('client_id', $userId)->where('status', 'done')->sum('amount');

        $nextReservation = Reservation::where('client_id', $userId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('date', '>=', now()->toDateString())
            ->with(['service', 'employee.user', 'salon'])
            ->orderBy('date')->orderBy('start_time')
            ->first();

        $upcomingReservations = Reservation::where('client_id', $userId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('date', '>=', now()->toDateString())
            ->with(['service', 'employee.user', 'salon'])
            ->orderBy('date')->orderBy('start_time')
            ->take(3)
            ->get();

        $favoritesCount = Favorite::where('user_id', $userId)->count();

        $recentFavorites = Favorite::where('user_id', $userId)
            ->with('service')
            ->latest()->take(4)->get();

        $recentNotifications = $user->notifications()->latest()->take(3)->get();
        $recentPayments      = Payment::where('client_id', $userId)->latest()->take(3)->get();

        $loyaltyStats  = \App\Services\LoyaltyService::getStats($user);
        $currentVip    = $user->vipSubscription;

        return view('client.dashboard', compact(
            'totalReservations',
            'pendingReservations',
            'completedReservations',
            'totalSpent',
            'nextReservation',
            'upcomingReservations',
            'favoritesCount',
            'recentFavorites',
            'recentNotifications',
            'recentPayments',
            'loyaltyStats',
            'currentVip'
        ));
    }

    public function addresses()
    {
        $addresses = Auth::user()->addresses()->orderByDesc('is_primary')->get();
        return view('client.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $data = $request->validate([
            'label'    => 'required|string|max:100',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'required|string|max:255',
            'city'     => 'required|string|max:100',
            'state'    => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
        ]);

        $data['user_id'] = Auth::id();

        if (Auth::user()->addresses()->count() === 0) {
            $data['is_primary'] = true;
        }

        Address::create($data);

        return redirect()->route('client.addresses')->with('success', 'Adresse ajoutée avec succès.');
    }

    public function updateAddress(Request $request, Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        $data = $request->validate([
            'label'    => 'required|string|max:100',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'required|string|max:255',
            'city'     => 'required|string|max:100',
            'state'    => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
        ]);

        $address->update($data);

        return redirect()->route('client.addresses')->with('success', 'Adresse mise à jour.');
    }

    public function deleteAddress(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        $wasPrimary = $address->is_primary;
        $address->delete();

        if ($wasPrimary) {
            $next = Auth::user()->addresses()->first();
            if ($next) {
                $next->update(['is_primary' => true]);
            }
        }

        return redirect()->route('client.addresses')->with('success', 'Adresse supprimée.');
    }

    public function setPrimaryAddress(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        Auth::user()->addresses()->update(['is_primary' => false]);
        $address->update(['is_primary' => true]);

        return redirect()->route('client.addresses')->with('success', 'Adresse principale mise à jour.');
    }

    public function clientPayments()
    {
        $payments = Payment::where('client_id', Auth::id())
            ->with(['reservation.service'])
            ->latest()
            ->get();

        return view('client.payments', compact('payments'));
    }

    public function clientNotifications()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        $unreadCount   = Auth::user()->unreadNotifications()->count();
        $notifPrefs    = Auth::user()->preferences ?? [];

        return view('client.notifications', compact('notifications', 'unreadCount', 'notifPrefs'));
    }

    public function markAllNotificationsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->route('client.notifications')
            ->with('success', __('messages.clt_mark_all_read_success'));
    }

    public function updateNotificationPreferences(Request $request)
    {
        $user = Auth::user();
        $prefs = $user->preferences ?? [];

        $prefs['notif_appointments'] = $request->boolean('notif_appointments');
        $prefs['notif_reminders']    = $request->boolean('notif_reminders');
        $prefs['notif_promotions']   = $request->boolean('notif_promotions');

        $user->preferences = $prefs;
        $user->save();

        return redirect()->route('client.notifications')
            ->with('success', __('messages.clt_prefs_updated'));
    }
}