<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class PlanningController extends Controller
{
    /**
     * Affichage du planning (admin / salon / employé)
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();

        $baseQuery = match(true) {
            $user->role === 'admin' => Reservation::with(['client', 'service', 'employee']),
            $user->role === 'employee' && $user->employee => Reservation::where('employee_id', $user->employee->id)->with(['service', 'client']),
            default => Reservation::where('client_id', $user->id)->with(['service']),
        };

        $weekOffset = (int) $request->get('week', 0);
        $weekStart  = now()->startOfWeek(\Carbon\Carbon::MONDAY)->addWeeks($weekOffset);
        $weekEnd    = $weekStart->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);

        $allReservations = (clone $baseQuery)->orderBy('date')->orderBy('start_time')->get();

        $weekReservations = (clone $baseQuery)
            ->whereBetween('date', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('date')->orderBy('start_time')
            ->get();

        $today     = now()->toDateString();
        $todayRdv  = $allReservations->filter(fn($r) => $r->date->toDateString() === $today);
        $upcoming  = $allReservations->filter(fn($r) => $r->date->toDateString() > $today && !in_array($r->status, ['cancelled']))->take(8);

        $stats = [
            'total'     => $allReservations->count(),
            'today'     => $todayRdv->count(),
            'confirmed' => $allReservations->where('status', 'confirmed')->count(),
            'pending'   => $allReservations->where('status', 'pending')->count(),
        ];

        // Build week-day columns
        $weekDays = collect(range(0, 6))->map(fn($d) => [
            'date'    => $weekStart->copy()->addDays($d)->toDateString(),
            'label'   => $weekStart->copy()->addDays($d)->locale('fr')->isoFormat('ddd D/M'),
            'isToday' => $weekStart->copy()->addDays($d)->toDateString() === $today,
        ]);

        // Build 30-min slots 08:00–20:00
        $timeSlots = [];
        $t = \Carbon\Carbon::createFromTimeString('08:00');
        while ($t->format('H:i') !== '20:00') {
            $timeSlots[] = $t->format('H:i');
            $t->addMinutes(30);
        }

        // Agenda map: date → slot → [reservations]
        $agendaMap = [];
        foreach ($weekReservations as $r) {
            $ct   = \Carbon\Carbon::createFromTimeString(substr($r->start_time, 0, 5));
            $slot = $ct->format('H') . ':' . ($ct->minute >= 30 ? '30' : '00');
            $agendaMap[$r->date->toDateString()][$slot][] = $r;
        }

        return view('planning.index', compact(
            'allReservations', 'weekReservations', 'todayRdv', 'upcoming',
            'stats', 'weekOffset', 'weekStart', 'weekEnd', 'weekDays', 'timeSlots', 'agendaMap'
        ));
    }
}