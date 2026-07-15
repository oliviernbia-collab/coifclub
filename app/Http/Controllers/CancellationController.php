<?php

namespace App\Http\Controllers;

use App\Models\Cancellation;
use App\Models\CancellationPolicy;
use App\Models\Reservation;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Auth;

class CancellationController extends Controller
{
    /**
     * Afficher les politiques d'annulation
     */
    public function policies()
    {
        $policies = CancellationPolicy::all();
        return view('cancellations.policies', compact('policies'));
    }

    /**
     * Client: demander une annulation
     */
    public function requestCancel(Request $request, Reservation $reservation)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        // Vérifier que c'est le client qui annule sa réservation
        if ($reservation->client_id !== Auth::id()) {
            return redirect()->back()->with('error', '❌ Non autorisé');
        }

        // Vérifier que la réservation peut être annulée
        if ($reservation->status !== 'pending' && $reservation->status !== 'confirmed') {
            return redirect()->back()->with('error', '❌ Cette réservation ne peut pas être annulée');
        }

        // Déterminer la politique d'annulation
        $policy = CancellationPolicy::getPolicyForReservation($reservation);

        // Calculer le montant du remboursement
        $refundAmount = ($reservation->amount * $policy->refund_percentage) / 100;

        // Créer la demande d'annulation
        $cancellation = Cancellation::create([
            'reservation_id' => $reservation->id,
            'reason' => $request->input('reason'),
            'refund_percentage' => $policy->refund_percentage,
            'refund_amount' => $refundAmount,
            'status' => 'pending',
        ]);

        ActivityLogger::log('cancel', "Demande d'annulation pour réservation #{$reservation->id} (remboursement : " . number_format($refundAmount, 2) . " $)", $cancellation);

        return redirect()->route('client.reservations')->with(
            'success',
            "✅ Demande d'annulation envoyée. Remboursement : " . number_format($refundAmount, 2) . " $"
        );
    }

    /**
     * Client: voir ses annulations
     */
    public function myRequests()
    {
        $user = Auth::user();
        $cancellations = Cancellation::whereHas('reservation', function ($q) use ($user) {
            $q->where('client_id', $user->id);
        })->latest()->paginate(10);

        return view('cancellations.my-requests', compact('cancellations'));
    }

    /**
     * Admin: gérer les annulations
     */
    public function adminIndex()
    {
        $cancellations = Cancellation::where('status', 'pending')
            ->with('reservation.client')
            ->latest()
            ->paginate(20);

        return view('cancellations.admin-index', compact('cancellations'));
    }

    /**
     * Admin: approuver une annulation
     */
    public function approve(Request $request, Cancellation $cancellation)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $cancellation->approve($request->input('notes'));

        ActivityLogger::log('approve', "Annulation #{$cancellation->id} approuvée par l'admin", $cancellation);

        return redirect()->back()->with('success', '✅ Annulation approuvée !');
    }

    /**
     * Admin: rejeter une annulation
     */
    public function reject(Request $request, Cancellation $cancellation)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $cancellation->reject($request->input('notes'));

        ActivityLogger::log('reject', "Annulation #{$cancellation->id} rejetée par l'admin", $cancellation);

        return redirect()->back()->with('success', '❌ Annulation rejetée !');
    }

    /**
     * Admin: gérer les politiques
     */
    public function managePolicies()
    {
        $policies = CancellationPolicy::all();
        return view('cancellations.manage-policies', compact('policies'));
    }

    /**
     * Admin: enregistrer une nouvelle politique
     */
    public function storePolicy(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hours_before' => 'required|integer|min:0|max:10000',
            'refund_percentage' => 'required|integer|min:0|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        CancellationPolicy::create([
            'name' => $request->input('name'),
            'hours_before' => $request->input('hours_before'),
            'refund_percentage' => $request->input('refund_percentage'),
            'description' => $request->input('description'),
        ]);

        return redirect()->back()->with('success', '✅ Politique créée !');
    }

    /**
     * Admin: mettre à jour une politique
     */
    public function updatePolicy(Request $request, CancellationPolicy $policy)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hours_before' => 'required|integer|min:0|max:10000',
            'refund_percentage' => 'required|integer|min:0|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $policy->update([
            'name' => $request->input('name'),
            'hours_before' => $request->input('hours_before'),
            'refund_percentage' => $request->input('refund_percentage'),
            'description' => $request->input('description'),
        ]);

        return redirect()->back()->with('success', '✅ Politique mise à jour !');
    }
}
