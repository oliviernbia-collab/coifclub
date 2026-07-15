<?php
// ═══════════════════════════════════════════════════
// app/Models/Salon.php
// ═══════════════════════════════════════════════════
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salon extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id','name','description','address','city',
        'phone','email','logo','opening_hours','is_active',
    ];

    protected $casts = [
        'opening_hours' => 'array',
        'is_active'     => 'boolean',
    ];

    public function owner()       { return $this->belongsTo(User::class, 'owner_id'); }
    public function services()    { return $this->hasMany(Service::class); }
    public function employees()   { return $this->hasMany(Employee::class); }
    public function reservations(){ return $this->hasMany(Reservation::class); }
    public function gallery()     { return $this->hasMany(Gallery::class); }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/default-salon.jpg');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class); // ou Avis::class selon ton modèle
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class); // ou Gallery::class selon ton modèle
    }
}
