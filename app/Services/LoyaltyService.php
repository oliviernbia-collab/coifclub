<?php

namespace App\Services;

use App\Models\{LoyaltyPoints, LoyaltyTransaction, Reservation, User};

class LoyaltyService
{
    /**
     * Points gagnés par réservation complétée
     */
    const POINTS_PER_RESERVATION = 10;

    /**
     * Points bonus pour anniversaire
     */
    const BIRTHDAY_BONUS = 50;

    /**
     * Tiers de fidélité
     */
    const TIERS = [
        1 => ['name' => 'Bronze', 'min_points' => 0, 'discount' => 0],
        2 => ['name' => 'Silver', 'min_points' => 100, 'discount' => 5],
        3 => ['name' => 'Gold', 'min_points' => 500, 'discount' => 10],
        4 => ['name' => 'Platinum', 'min_points' => 1000, 'discount' => 15],
    ];

    /**
     * Initialiser le compte fidélité pour un nouvel utilisateur
     */
    public static function initializeForUser(User $user): void
    {
        if (!$user->loyaltyPoints) {
            LoyaltyPoints::create([
                'user_id' => $user->id,
                'balance' => 0,
                'lifetime_points' => 0,
                'tier' => 1,
            ]);
        }
    }

    /**
     * Ajouter des points après une réservation complétée
     */
    public static function awardPointsForReservation(Reservation $reservation): void
    {
        // Éviter le double-award si confirm() est appelé plusieurs fois
        if (LoyaltyTransaction::where('reservation_id', $reservation->id)->exists()) {
            return;
        }

        $user = $reservation->client;

        if (!$user->loyaltyPoints) {
            self::initializeForUser($user);
        }

        // Recharger la relation pour éviter un cache null après initializeForUser()
        $loyalty = $user->loyaltyPoints()->first();
        $points = self::POINTS_PER_RESERVATION;

        // Bonus anniversaire
        if (self::isBirthday($user)) {
            $points += self::BIRTHDAY_BONUS;
        }

        $loyalty->addPoints($points, 'Réservation complétée', $reservation->id);
    }

    /**
     * Utiliser des points pour une réduction
     */
    public static function redeemPoints(User $user, int $pointsToSpend): array
    {
        $loyalty = $user->loyaltyPoints;

        if (!$loyalty || $loyalty->balance < $pointsToSpend) {
            return ['success' => false, 'message' => 'Points insuffisants'];
        }

        $discountAmount = self::calculateDiscount($pointsToSpend);

        if ($loyalty->spendPoints($pointsToSpend, 'Utilisation pour réduction')) {
            return [
                'success' => true,
                'discount' => $discountAmount,
                'points_spent' => $pointsToSpend,
            ];
        }

        return ['success' => false, 'message' => 'Erreur lors de l\'utilisation des points'];
    }

    /**
     * Calculer la réduction basée sur les points
     * 1 point = 10 $ de réduction
     */
    public static function calculateDiscount(int $points): float
    {
        return $points * 10; // 1 point = 10 $
    }

    /**
     * Obtenir le tier actuel de l'utilisateur
     */
    public static function getUserTier(User $user): array
    {
        $loyalty = $user->loyaltyPoints;

        if (!$loyalty) {
            return self::TIERS[1];
        }

        return self::TIERS[$loyalty->tier] ?? self::TIERS[1];
    }

    /**
     * Vérifier si c'est l'anniversaire de l'utilisateur
     */
    private static function isBirthday(User $user): bool
    {
        if (!$user->birth_date) {
            return false;
        }

        $today = now()->format('m-d');
        $birthDate = \Carbon\Carbon::parse($user->birth_date)->format('m-d');

        return $today === $birthDate;
    }

    /**
     * Obtenir les statistiques de fidélité
     */
    public static function getStats(User $user): array
    {
        $loyalty = $user->loyaltyPoints;

        if (!$loyalty) {
            return [
                'balance' => 0,
                'lifetime' => 0,
                'tier' => 'Bronze',
                'discount_percentage' => 0,
                'next_tier_points' => 100,
            ];
        }

        $currentTier = self::TIERS[$loyalty->tier];
        $nextTier = self::TIERS[$loyalty->tier + 1] ?? null;

        return [
            'balance' => $loyalty->balance,
            'lifetime' => $loyalty->lifetime_points,
            'tier' => $currentTier['name'],
            'discount_percentage' => $currentTier['discount'],
            'next_tier_points' => $nextTier ? $nextTier['min_points'] - $loyalty->lifetime_points : 0,
        ];
    }
}