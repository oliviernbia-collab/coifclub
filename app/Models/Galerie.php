<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galerie extends Model
{
    use HasFactory;

    protected $table = 'galeries';

    protected $fillable = [
        'salon_id',
        'image',
        'titre',
        'description',
    ];

    /**
     * Une image de galerie appartient à un salon
     */
    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }
}