<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoyaltyPoints extends Model
{
    use HasFactory;

    protected $table = 'loyalty_points';

    protected $fillable = [
        'user_id',
        'balance',
        'lifetime_points',
        'tier',
        'tier_updated_at',
    ];

    protected $casts = [
        'tier_updated_at' => 'datetime',
    ];

    // ── Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(LoyaltyTransaction::class, 'user_id', 'user_id');
    }

    // ── Méthodes
    public function addPoints($points, $reason, $reservationId = null): void
    {
        $this->increment('balance', $points);
        $this->increment('lifetime_points', $points);
        $this->save();

        LoyaltyTransaction::create([
            'user_id' => $this->user_id,
            'reservation_id' => $reservationId,
            'points_earned' => $points,
            'reason' => $reason,
            'status' => 'completed',
        ]);

        $this->checkTierUpgrade();
    }

    public function spendPoints($points, $reason = 'redemption'): bool
    {
        if ($this->balance < $points) {
            return false;
        }

        $this->decrement('balance', $points);
        $this->save();

        LoyaltyTransaction::create([
            'user_id' => $this->user_id,
            'points_spent' => $points,
            'reason' => $reason,
            'status' => 'completed',
        ]);

        return true;
    }

    public function checkTierUpgrade(): void
    {
        $newTier = match (true) {
            $this->lifetime_points >= 1000 => 4, // Platinum
            $this->lifetime_points >= 500 => 3,  // Gold
            $this->lifetime_points >= 100 => 2,  // Silver
            default => 1, // Bronze
        };

        if ($newTier !== $this->tier) {
            $this->update([
                'tier' => $newTier,
                'tier_updated_at' => now(),
            ]);
        }
    }

    public function getTierNameAttribute(): string
    {
        return match ($this->tier) {
            1 => 'Bronze',
            2 => 'Silver',
            3 => 'Gold',
            4 => 'Platinum',
            default => 'Bronze',
        };
    }
}
