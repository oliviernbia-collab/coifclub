<?php

namespace App\Models;

use App\Services\LoyaltyService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference','client_id','service_id','employee_id','salon_id',
        'date','start_time','end_time','amount','status',
        'client_notes','current_hair_image','desired_style_image',
        'terms_conditions','terms_delays','terms_refunds','terms_signed_at',
        'admin_notes','confirmed_at','cancelled_at','cancellation_reason',
    ];

    protected $casts = [
        'date'         => 'date',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($reservation) {
            $year   = date('Y');
            $prefix = 'RES-' . $year . '-';

            $last = static::where('reference', 'like', $prefix . '%')
                ->orderByRaw('CAST(SUBSTRING(reference, ' . (strlen($prefix) + 1) . ') AS UNSIGNED) DESC')
                ->value('reference');

            $next = $last ? (intval(substr($last, strlen($prefix))) + 1) : 1;

            $candidate = $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
            while (static::where('reference', $candidate)->exists()) {
                $next++;
                $candidate = $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
            }

            $reservation->reference = $candidate;
        });
    }

    // ── Relations ──────────────────────────────────
    public function client()   { return $this->belongsTo(User::class, 'client_id'); }
    public function service()  { return $this->belongsTo(Service::class); }
    public function employee() { return $this->belongsTo(Employee::class); }
    public function salon()    { return $this->belongsTo(Salon::class); }
    public function payment()  { return $this->hasOne(Payment::class); }
    public function review()   { return $this->hasOne(Review::class); }

    // ── Statuts ────────────────────────────────────
    public function isPending():    bool { return $this->status === 'pending'; }
    public function isConfirmed():  bool { return $this->status === 'confirmed'; }
    public function isDone():       bool { return $this->status === 'done'; }
    public function isCancelled():  bool { return $this->status === 'cancelled'; }

    public function confirm(): void
    {
        $this->update(['status' => 'confirmed', 'confirmed_at' => now()]);
        LoyaltyService::awardPointsForReservation($this);
    }

    public function cancel(string $reason = null): void
    {
        $this->update([
            'status'              => 'cancelled',
            'cancelled_at'        => now(),
            'cancellation_reason' => $reason,
        ]);
    }

    public function markDone(): void
    {
        $this->update(['status' => 'done']);
    }

    // ── Accesseurs ─────────────────────────────────
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'En attente',
            'confirmed'   => 'Confirmée',
            'in_progress' => 'En cours',
            'done'        => 'Terminée',
            'cancelled'   => 'Annulée',
            'no_show'     => 'Absente',
            default       => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'warning',
            'confirmed' => 'info',
            'done'      => 'success',
            'cancelled' => 'danger',
            default     => 'secondary',
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, '.', ',');
    }
}
