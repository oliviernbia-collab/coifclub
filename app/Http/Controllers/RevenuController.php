<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class RevenuController extends Controller
{
    /**
     * Affichage des revenus
     */
    public function index()
    {
        $user = Auth::user();

        // 🔹 ADMIN : tous les revenus
        if ($user->role === 'admin') {

            $reservations = Reservation::with('service')
                ->where('status', 'completed')
                ->get();

        }

        // 🔹 SALON : revenus de ses services uniquement
        elseif ($user->role === 'salon') {

            $reservations = Reservation::whereHas('service', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with('service')
                ->where('status', 'completed')
                ->get();

        }

        // 🔹 EMPLOYÉ : revenus de ses rendez-vous terminés
        elseif ($user->role === 'employee') {

            abort_unless($user->employee, 404);

            $reservations = Reservation::where('employee_id', $user->employee->id)
                ->with('service')
                ->whereIn('status', ['completed', 'done'])
                ->get();

        }
        // 🔹 CLIENT : pas de revenus (option sécurité)
        else {
            $reservations = collect();
        }

        // 💰 Calcul du total des revenus
        $totalRevenus = $reservations->sum(function ($reservation) {
            return $reservation->service->price ?? 0;
        });

        // 📊 Revenus mensuels (optionnel)
        $revenusParMois = $reservations->groupBy(function ($item) {
            return $item->created_at->format('Y-m');
        })->map(function ($group) {
            return $group->sum(function ($r) {
                return $r->service->price ?? 0;
            });
        });

        return view('revenus.index', compact('reservations', 'totalRevenus', 'revenusParMois'));
    }
}