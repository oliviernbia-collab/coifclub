<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id','client_id','transaction_id','amount',
        'method','status','phone_number','cash_name','gateway_response','paid_at',
        'proof_path','approved_at',
    ];

    protected $casts = [
        'gateway_response' => 'array',
        'paid_at'          => 'datetime',
        'approved_at'      => 'datetime',
    ];

    public function reservation() { return $this->belongsTo(Reservation::class); }
    public function client()      { return $this->belongsTo(User::class, 'client_id'); }
    public function user()        { return $this->client(); }

    public function isCompleted(): bool { return $this->status === 'completed'; }
    public function isFailed():    bool { return $this->status === 'failed'; }

    public function getMethodLabelAttribute(): string
    {
        return match($this->method) {
            'orange_money' => 'Orange Money',
            'mtn_money'    => 'MTN Money',
            'wave'         => 'Wave',
            'stripe'       => 'Carte bancaire',
            'paypal'       => 'PayPal',
            'apple_pay'    => 'Apple Pay',
            'google_pay'   => 'Google Pay',
            'cash'         => 'Espèces',
            default        => ucfirst(str_replace('_', ' ', $this->method)),
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, '.', ',');
    }

    public function getProofUrlAttribute(): ?string
    {
        return $this->proof_path ? asset('storage/' . $this->proof_path) : null;
    }

    
}
