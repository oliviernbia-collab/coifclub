<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','salon_id','specialty','bio','phone','photo','is_available','working_days',
    ];

    protected $casts = [
        'working_days' => 'array',
        'is_available' => 'boolean',
    ];

    public function user()           { return $this->belongsTo(User::class); }
    public function salon()          { return $this->belongsTo(Salon::class); }
    public function services()       { return $this->belongsToMany(Service::class); }
    public function reservations()   { return $this->hasMany(Reservation::class); }
    public function availabilities() { return $this->hasMany(Availability::class); }
    public function unavailabilities() { return $this->hasMany(Unavailability::class); }
    public function reviews()        { return $this->hasMany(Review::class); }

    // Retourne les créneaux libres pour une date donnée
    public function getAvailableSlots(string $date): array
    {
        $dayName = Carbon::parse($date)->locale('fr')->dayName;
        $availability = $this->availabilities()
            ->where('day_of_week', $dayName)
            ->where('is_active', true)
            ->first();

        if (!$availability) return [];

        // Vérifier les indisponibilités ponctuelles
        $hasUnavailability = $this->unavailabilities()
            ->where('date', $date)
            ->first();

        if ($hasUnavailability && $hasUnavailability->isAllDay()) {
            return [];
        }

        // Créneaux déjà pris
        $bookedSlots = $this->reservations()
            ->where('date', $date)
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->pluck('start_time')
            ->map(fn($t) => substr($t, 0, 5))
            ->toArray();

        $slot = $availability->slot_duration ?? 30;
        if ($slot <= 0) {
            return [];
        }

        // Génère tous les créneaux
        $slots = [];
        $current = Carbon::parse($date . ' ' . $availability->start_time);
        $end = Carbon::parse($date . ' ' . $availability->end_time);

        while ($current->copy()->addMinutes($slot)->lte($end)) {
            $time = $current->format('H:i');
            if (!in_array($time, $bookedSlots)) {
                $slots[] = $time;
            }
            $current->addMinutes($slot);
        }

        return $slots;
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->count() > 0 ? $this->reviews()->avg('rating') : 0;
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name ?? 'E') . '&background=fdf0e8&color=c87e5a';
    }

    // Alias pour image_url (utilisé dans la vue)
    public function getImageUrlAttribute(): string
    {
        return $this->photo_url;
    }

    public function getNameAttribute(): ?string
    {
        return $this->user?->name;
    }
}

