<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VipSubscription extends Model
{
    use HasFactory;

    protected $table = 'vip_subscriptions';

    protected $fillable = [
        'user_id',
        'plan',
        'price',
        'status',
        'started_at',
        'ends_at',
        'renewal_at',
        'reservation_count_included',
        'discount_percentage',
        'priority_booking',
        'free_service_monthly',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
        'renewal_at' => 'datetime',
        'priority_booking' => 'boolean',
        'free_service_monthly' => 'boolean',
    ];

    // ── Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Méthodes
    public function isActive(): bool
    {
        return $this->status === 'active' && now() <= $this->ends_at;
    }

    public function renew(): void
    {
        $this->update([
            'started_at' => now(),
            'ends_at' => match ($this->plan) {
                'monthly' => now()->addMonth(),
                'quarterly' => now()->addMonths(3),
                'annual' => now()->addYear(),
                default => now()->addMonth(),
            },
            'renewal_at' => now(),
            'status' => 'active',
        ]);
    }

    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function getPlanPriceAttribute(): array
    {
        return match ($this->plan) {
            'monthly' => ['price' => 29.99, 'duration' => '1 mois'],
            'quarterly' => ['price' => 79.99, 'duration' => '3 mois'],
            'annual' => ['price' => 299.99, 'duration' => '1 an'],
            default => ['price' => 29.99, 'duration' => '1 mois'],
        };
    }
}
