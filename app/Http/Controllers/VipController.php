<?php

namespace App\Http\Controllers;

use App\Models\VipSubscription;
use Illuminate\Http\Request;
use Auth;
use App\Services\VipSubscriptionService;

class VipController extends Controller
{
    /**
     * Afficher les plans VIP disponibles
     */
    public function plans()
    {
        $user = Auth::user();
        $currentVip = $user->vipSubscription;
        $plans = VipSubscriptionService::getAvailablePlans();

        return view('client.vip.plans', compact('plans', 'currentVip'));
    }

    /**
     * Souscrire à un plan VIP
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:monthly,quarterly,annual',
        ]);

        $user = Auth::user();

        if (VipSubscriptionService::hasActiveSubscription($user)) {
            return back()->with('error', 'Vous avez déjà un abonnement VIP actif.');
        }

        try {
            VipSubscriptionService::createSubscription($user, $request->plan);

            return redirect()->route('client.vip.plans')
                ->with('success', 'Votre abonnement VIP a été activé avec succès !');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création de l\'abonnement : ' . $e->getMessage());
        }
    }

    /**
     * Annuler l'abonnement VIP
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->vipSubscription;

        if (!$subscription || !$subscription->isActive()) {
            return back()->with('error', 'Aucun abonnement actif trouvé.');
        }

        try {
            $endsAt = $subscription->ends_at->format('d/m/Y');
            VipSubscriptionService::cancelSubscription($subscription);

            return redirect()->route('client.vip.plans')
                ->with('success', "Votre abonnement a été annulé. Vous conserverez vos avantages VIP jusqu'au {$endsAt}.");

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'annulation : ' . $e->getMessage());
        }
    }

    /**
     * Interface admin pour gérer les abonnements VIP
     */
    public function adminIndex(Request $request)
    {
        $query = VipSubscription::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        $subscriptions = $query->paginate(20)->withQueryString();

        $stats = [
            'total'     => VipSubscription::count(),
            'active'    => VipSubscription::where('status', 'active')->count(),
            'cancelled' => VipSubscription::where('status', 'cancelled')->count(),
            'revenue'   => VipSubscription::where('status', 'active')->sum('price'),
        ];

        return view('admin.vip.index', compact('subscriptions', 'stats'));
    }

    /**
     * Annuler un abonnement VIP (action admin)
     */
    public function adminCancel(VipSubscription $subscription)
    {
        $subscription->update(['status' => 'cancelled']);

        return back()->with('success', 'Abonnement VIP annulé avec succès.');
    }
}
