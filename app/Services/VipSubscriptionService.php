<?php

namespace App\Services;

use App\Models\VipSubscription;
use App\Models\User;

class VipSubscriptionService
{
    /**
     * Plans d'abonnement VIP
     */
    const PLANS = [
        'monthly' => [
            'name' => 'Mensuel',
            'price' => 29990, // 299.90 $
            'duration_months' => 1,
            'benefits' => [
                'priority_booking' => true,
                'discount_percentage' => 10,
                'reservation_count_included' => 4,
                'free_service_monthly' => false,
            ]
        ],
        'quarterly' => [
            'name' => 'Trimestriel',
            'price' => 79990, // 799.90 $
            'duration_months' => 3,
            'benefits' => [
                'priority_booking' => true,
                'discount_percentage' => 15,
                'reservation_count_included' => 12,
                'free_service_monthly' => true,
            ]
        ],
        'annual' => [
            'name' => 'Annuel',
            'price' => 299990, // 2999.90 $
            'duration_months' => 12,
            'benefits' => [
                'priority_booking' => true,
                'discount_percentage' => 20,
                'reservation_count_included' => 50,
                'free_service_monthly' => true,
            ]
        ],
    ];

    /**
     * Créer un nouvel abonnement VIP
     */
    public static function createSubscription(User $user, string $plan): VipSubscription
    {
        if (!isset(self::PLANS[$plan])) {
            throw new \InvalidArgumentException("Plan d'abonnement invalide");
        }

        $planData = self::PLANS[$plan];

        return VipSubscription::create([
            'user_id' => $user->id,
            'plan' => $plan,
            'price' => $planData['price'],
            'status' => 'active',
            'started_at' => now(),
            'ends_at' => now()->addMonths($planData['duration_months']),
            'renewal_at' => now(),
            'reservation_count_included' => $planData['benefits']['reservation_count_included'],
            'discount_percentage' => $planData['benefits']['discount_percentage'],
            'priority_booking' => $planData['benefits']['priority_booking'],
            'free_service_monthly' => $planData['benefits']['free_service_monthly'],
        ]);
    }

    /**
     * Renouveler un abonnement
     */
    public static function renewSubscription(VipSubscription $subscription): void
    {
        $planData = self::PLANS[$subscription->plan];
        $subscription->update([
            'started_at' => now(),
            'ends_at' => now()->addMonths($planData['duration_months']),
            'renewal_at' => now(),
            'status' => 'active',
        ]);
    }

    /**
     * Annuler un abonnement
     */
    public static function cancelSubscription(VipSubscription $subscription): void
    {
        $subscription->cancel();
    }

    /**
     * Vérifier si l'utilisateur a un abonnement actif
     */
    public static function hasActiveSubscription(User $user): bool
    {
        return $user->vipSubscription && $user->vipSubscription->isActive();
    }

    /**
     * Obtenir les avantages de l'abonnement actif
     */
    public static function getSubscriptionBenefits(User $user): array
    {
        if (!self::hasActiveSubscription($user)) {
            return [
                'is_active' => false,
                'plan' => null,
                'discount_percentage' => 0,
                'priority_booking' => false,
                'free_service_monthly' => false,
                'reservations_remaining' => 0,
            ];
        }

        $subscription = $user->vipSubscription;

        return [
            'is_active' => true,
            'plan' => $subscription->plan,
            'plan_name' => self::PLANS[$subscription->plan]['name'],
            'discount_percentage' => $subscription->discount_percentage,
            'priority_booking' => $subscription->priority_booking,
            'free_service_monthly' => $subscription->free_service_monthly,
            'reservations_remaining' => $subscription->reservation_count_included,
            'ends_at' => $subscription->ends_at,
        ];
    }

    /**
     * Calculer le prix avec réduction VIP
     */
    public static function calculateDiscountedPrice(User $user, float $originalPrice): float
    {
        $benefits = self::getSubscriptionBenefits($user);

        if (!$benefits['is_active']) {
            return $originalPrice;
        }

        $discount = $originalPrice * ($benefits['discount_percentage'] / 100);
        return $originalPrice - $discount;
    }

    /**
     * Obtenir tous les plans disponibles
     */
    public static function getAvailablePlans(): array
    {
        return self::PLANS;
    }
}