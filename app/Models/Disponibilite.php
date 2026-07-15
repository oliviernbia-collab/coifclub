<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disponibilite extends Model
{
    use HasFactory;

    protected $table = 'disponibilites';

    protected $fillable = [
        'user_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'statut',
    ];

    /**
     * Une disponibilité appartient à un utilisateur (coiffeur / employé)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}