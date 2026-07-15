<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    protected $fillable = [
        'user_id',
        'reservation_id',
        'montant',
        'mode_paiement',
        'statut',
        'reference',
        'date_paiement',
    ];

    /**
     * Un paiement appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un paiement est lié à une réservation
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}