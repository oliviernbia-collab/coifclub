<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions';

    protected $fillable = [
        'code',
        'description',
        'type',
        'category',
        'value',
        'usage_limit',
        'usage_count',
        'valid_from',
        'valid_until',
        'is_active',
        'status',
        'minimum_amount',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public static function getTypes(): array
    {
        return [
            'percentage' => __('messages.promotion_type_percentage'),
            'fixed_amount' => __('messages.promotion_type_fixed_amount'),
            'free_service' => __('messages.promotion_type_free_service'),
        ];
    }

    public static function getCategories(): array
    {
        return [
            'general' => __('messages.promo_category_general'),
            'black_friday' => __('messages.promo_category_black_friday'),
            'weekend' => __('messages.promo_category_weekend'),
            'student' => __('messages.promo_category_student'),
        ];
    }

    // ── Méthodes de validation
    public function isValid(): bool
    {
        return $this->is_active
            && $this->status === 'active'
            && now() >= $this->valid_from
            && now() <= $this->valid_until
            && (!$this->usage_limit || $this->usage_count < $this->usage_limit);
    }

    public function canBeUsed($amount = 0): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($this->minimum_amount && $amount < $this->minimum_amount) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($amount): float
    {
        return match ($this->type) {
            'percentage' => ($amount * $this->value) / 100,
            'fixed_amount' => min($this->value, $amount),
            'free_service', 'free' => $this->value,
            default => 0,
        };
    }

    public function use(): void
    {
        $this->increment('usage_count');
    }

    public function getStatusLabelAttribute(): string
    {
        if (! $this->is_active) {
            return __('messages.promotion_status_disabled');
        }

        if ($this->status !== 'active') {
            return __('messages.promotion_status_' . $this->status);
        }

        if (now() < $this->valid_from) {
            return __('messages.promotion_status_upcoming');
        }

        if (now() > $this->valid_until) {
            return __('messages.promotion_status_expired');
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return __('messages.promotion_status_limit_reached');
        }

        return __('messages.promotion_status_active');
    }

    public function getTypeLabelAttribute(): string
    {
        return self::getTypes()[$this->type] ?? ucfirst($this->type);
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::getCategories()[$this->category] ?? ucfirst(str_replace('_', ' ', $this->category));
    }
}
