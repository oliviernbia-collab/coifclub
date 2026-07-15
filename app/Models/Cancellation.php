<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cancellation extends Model
{
    use HasFactory;

    protected $table = 'cancellations';

    protected $fillable = [
        'reservation_id',
        'reason',
        'refund_percentage',
        'refund_amount',
        'status',
        'admin_notes',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // ── Relations
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // ── Méthodes
    public function approve($notes = null): void
    {
        $this->update([
            'status' => 'approved',
            'admin_notes' => $notes,
            'approved_at' => now(),
        ]);

        // Traiter le remboursement
        $reservation = $this->reservation;
        $payment = $reservation->payment;

        if ($payment && $this->refund_amount > 0) {
            // Marquer le paiement comme remboursé
            $payment->update([
                'status' => 'refunded',
                'refund_amount' => $this->refund_amount,
                'refunded_at' => now(),
            ]);
        }
    }

    public function reject($notes = null): void
    {
        $this->update([
            'status' => 'rejected',
            'admin_notes' => $notes,
        ]);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'En attente',
            'approved' => 'Approuvée',
            'rejected' => 'Refusée',
            default => $this->status,
        };
    }
}
