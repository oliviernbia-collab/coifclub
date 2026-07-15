<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Service;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
    ];

    /**
     * Utilisateur propriétaire du favori
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Service favori
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}