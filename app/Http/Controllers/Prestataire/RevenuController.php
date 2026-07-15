<?php

namespace App\Http\Controllers\Prestataire;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class RevenuController extends Controller
{
    // 👇 ICI tu mets ta méthode
    public function index()
    {
        $userId = Auth::id();

        $reservations = Reservation::whereHas('service', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'completed')->with('service')->get();

        $totalRevenue = $reservations->sum(function ($r) {
            return $r->service->price ?? 0;
        });

        $monthlyRevenue = $reservations->groupBy(function ($r) {
            return $r->created_at->format('M');
        })->map(function ($group) {
            return $group->sum(function ($r) {
                return $r->service->price ?? 0;
            });
        });

        return view('prestataire.revenus.index', [
            'totalRevenue' => $totalRevenue,
            'labels' => $monthlyRevenue->keys(),
            'data' => $monthlyRevenue->values()
        ]);
    }
}