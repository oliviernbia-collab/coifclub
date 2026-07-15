<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'avatar', 'is_active',
        'birth_date', 'habits', 'preferences', 'allergies', 'is_super_admin',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
        'is_super_admin'    => 'boolean',
        'birth_date'        => 'date',
        'preferences'       => 'array',
    ];

    // ── Rôles ──────────────────────────────────────
    public function isAdmin(): bool      { return $this->role === 'admin'; }
    public function isEmployee(): bool   { return $this->role === 'employee'; }
    public function isClient(): bool     { return $this->role === 'client'; }
    public function isSuperAdmin(): bool { return (bool) $this->is_super_admin; }

    // ── Relations ──────────────────────────────────
    public function salon()
    {
        return $this->hasOne(Salon::class, 'owner_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function reservationsAsClient()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'client_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    // ── NOUVELLES RELATIONS (Fidélité, VIP, etc.)
    public function loyaltyPoints()
    {
        return $this->hasOne(LoyaltyPoints::class);
    }

    public function loyaltyTransactions()
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }

    public function vipSubscription()
    {
        return $this->hasOne(VipSubscription::class)->latestOfMany();
    }

    public function addresses()
    {
        return $this->hasMany(Address::class)->orderByDesc('is_primary');
    }

    public function cancellations()
    {
        return $this->hasManyThrough(Cancellation::class, Reservation::class, 'client_id');
    }

    // ── Accesseurs ─────────────────────────────────
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=f0e6da&color=c87e5a';
    }

    // ── Méthodes pratiques (Fidélité)
    public function getOrCreateLoyaltyPoints()
    {
        return $this->loyaltyPoints()->firstOrCreate(['user_id' => $this->id]);
    }

    public function isVip(): bool
    {
        return $this->vipSubscription && $this->vipSubscription->isActive();
    }

    public function getVipDiscount(): int
    {
        return $this->isVip() ? $this->vipSubscription->discount_percentage : 0;
    }

    public function home()
    {
        $salons = Salon::latest()->take(6)->get();
        $services = Service::latest()->take(6)->get();

        // ✅ AJOUT OBLIGATOIRE ICI
        $stylists = User::where('role', 'employee')
        ->whereNotNull('image')
        ->inRandomOrder()
        ->take(4)
        ->get();

        return view('landing.premium', compact(
            'salons',
            'services',
            'stylists'
        ));
    }
}
