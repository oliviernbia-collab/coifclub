<?php

namespace App\Http\Controllers\Prestataire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class PlanningController extends Controller
{
    /**
     * Afficher le planning du prestataire
     */
    public function index()
    {
        $userId = Auth::id();

        // Réservations du prestataire
       $reservations = Reservation::with(['service', 'client'])
        ->whereHas('service', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // événements calendrier (FullCalendar / UI)
        $events = $reservations->map(function ($r) {
            return [
                'title' => $r->service->name ?? 'Service',
                'start' => $r->date_reservation . 'T' . $r->heure_reservation,
                'color' => $r->status === 'completed' ? '#22c55e' : '#f59e0b',
            ];
        });

        return view('prestataire.planning.index', compact('reservations', 'events'));
    }
}