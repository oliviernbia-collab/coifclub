<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Avis extends Model
{
    use HasFactory;

    protected $table = 'avis';

    protected $fillable = [
        'user_id',
        'salon_id',
        'note',
        'commentaire',
    ];

    /**
     * Un avis appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un avis appartient à un salon
     */
    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }
}