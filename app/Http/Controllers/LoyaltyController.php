<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyPoints;
use App\Models\LoyaltyTransaction;
use App\Services\LoyaltyService;
use App\Notifications\LoyaltyPointsAwarded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;

class LoyaltyController extends Controller
{
    /**
     * Dashboard fidélité client
     */
    public function index()
    {
        $user = Auth::user();
        $loyalty = $user->getOrCreateLoyaltyPoints();
        $loyaltyStats = LoyaltyService::getStats($user);

        $transactions = LoyaltyTransaction::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('loyalty.dashboard', compact('loyalty', 'loyaltyStats', 'transactions'));
    }

    /**
     * Ajouter des points après une réservation
     */
    public function addPointsForReservation($reservation)
    {
        $amount = $reservation->amount ?? 0;
        $pointsToAdd = (int) ($amount / 1000); // 1 point par 1000 $

        if ($pointsToAdd > 0) {
            $loyalty = $reservation->client->getOrCreateLoyaltyPoints();
            $loyalty->addPoints($pointsToAdd, 'reservation', $reservation->id);
        }
    }

    /**
     * Utilisateur veut rédemption ses points pour réduction
     */
    public function redeem(Request $request)
    {
        $validated = $request->validate([
            'points' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $loyalty = $user->getOrCreateLoyaltyPoints();

        $pointsToSpend = $validated['points'];

        if ($loyalty->spendPoints($pointsToSpend, 'redemption')) {
            // Créer un code promo automatiquement
            $discount = $pointsToSpend / 10; // 10 points = 1 $ de réduction
            return redirect()->back()->with('success', "✅ ${discount} $ de réduction générée !");
        }

        return redirect()->back()->with('error', '❌ Points insuffisants');
    }

    /**
     * Admin: voir les points de tous les clients
     */
    public function adminIndex()
    {
        $loyaltyPoints = LoyaltyPoints::with('user')
            ->orderBy('lifetime_points', 'desc')
            ->paginate(20);

        return view('loyalty.admin-index', compact('loyaltyPoints'));
    }

    /**
     * Admin: ajouter des points bonus à un client
     */
    public function adminAddBonus(Request $request, $userId)
    {
        $request->validate([
            'points' => 'required|integer|min:1',
            'reason' => 'required|string',
        ]);

        $user = \App\Models\User::findOrFail($userId);
        $loyalty = $user->getOrCreateLoyaltyPoints();

        $points = $request->input('points');
        $reason = $request->input('reason');

        $loyalty->addPoints($points, $reason, null);

        try {
            $user->notify(new LoyaltyPointsAwarded($points, $reason, $loyalty->fresh()->balance));
        } catch (\Exception $e) {
            Log::error('Failed to send LoyaltyPointsAwarded notification', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
        }

        return redirect()->back()->with('success', $points . ' points ajoutés à ' . $user->name . ' avec succès.');
    }
}
