<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Favorite;
use App\Models\Like;
use App\Models\User;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
    'salon_id',
    'categorie_id',
    'name',
    'description',
    'price',
    'duration',
    'image',
    'emoji',
    'is_active',
    'sort_order',
];

    protected $casts = ['is_active' => 'boolean'];

    public function salon()       { return $this->belongsTo(Salon::class); }
    public function categorie()   { return $this->belongsTo(Categorie::class); }
    public function employees()   { return $this->belongsToMany(Employee::class); }
    public function reservations(){ return $this->hasMany(Reservation::class); }
    public function reviews()     { return $this->hasMany(Review::class); }
    public function favorites()   { return $this->hasMany(Favorite::class); }
    public function likes()       { return $this->morphMany(Like::class, 'likeable'); }

    public function isFavoritedBy(?User $user): bool
    {
        return $user ? $this->favorites()->where('user_id', $user->id)->exists() : false;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-service.jpg');
    }

    // Durée formatée : 90min → "1h 30min"
    public function getFormattedDurationAttribute(): string
    {
        $h = intdiv($this->duration, 60);
        $m = $this->duration % 60;
        return ($h > 0 ? "{$h}h " : '') . ($m > 0 ? "{$m}min" : '');
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, '.', ',');
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

}
