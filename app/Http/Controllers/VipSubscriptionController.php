<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\VipSubscriptionService;
use App\Models\VipSubscription;

class VipSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher les plans d'abonnement VIP
     */
    public function index()
    {
        $plans = VipSubscriptionService::getAvailablePlans();
        $currentSubscription = Auth::user()->vipSubscription;

        return view('client.vip.index', compact('plans', 'currentSubscription'));
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

        // Vérifier si l'utilisateur a déjà un abonnement actif
        if (VipSubscriptionService::hasActiveSubscription($user)) {
            return back()->with('error', 'Vous avez déjà un abonnement VIP actif.');
        }

        try {
            $subscription = VipSubscriptionService::createSubscription($user, $request->plan);

            return redirect()->route('client.vip.index')
                ->with('success', 'Votre abonnement VIP a été activé avec succès !');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création de l\'abonnement : ' . $e->getMessage());
        }
    }

    /**
     * Renouveler l'abonnement
     */
    public function renew(Request $request)
    {
        $user = Auth::user();

        if (!$user->vipSubscription) {
            return back()->with('error', 'Aucun abonnement trouvé.');
        }

        try {
            VipSubscriptionService::renewSubscription($user->vipSubscription);

            return back()->with('success', 'Votre abonnement a été renouvelé avec succès !');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du renouvellement : ' . $e->getMessage());
        }
    }

    /**
     * Annuler l'abonnement
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();

        if (!$user->vipSubscription) {
            return back()->with('error', 'Aucun abonnement trouvé.');
        }

        try {
            VipSubscriptionService::cancelSubscription($user->vipSubscription);

            return back()->with('success', 'Votre abonnement a été annulé.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'annulation : ' . $e->getMessage());
        }
    }

    /**
     * Afficher les avantages VIP
     */
    public function benefits()
    {
        $user = Auth::user();
        $benefits = VipSubscriptionService::getSubscriptionBenefits($user);

        return view('client.vip.benefits', compact('benefits'));
    }
}