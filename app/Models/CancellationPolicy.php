<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CancellationPolicy extends Model
{
    use HasFactory;

    protected $table = 'cancellation_policies';

    protected $fillable = [
        'name',
        'hours_before',
        'refund_percentage',
        'description',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // ── Relations
    public function cancellations()
    {
        return $this->hasMany(Cancellation::class);
    }

    // ── Méthodes
    public static function getDefault()
    {
        return static::where('is_default', true)
            ->first() 
            ?? static::first() 
            ?? new static([
                'name' => 'Politique d\'annulation standard',
                'hours_before' => 0,
                'refund_percentage' => 0,
                'description' => 'Aucune politique d\'annulation définie.',
                'is_default' => true,
            ]);
    }

    public static function getPolicyForReservation($reservation)
    {
        $hoursUntil = now()->diffInHours($reservation->start_time, false);

        return static::where('hours_before', '<=', abs($hoursUntil))
            ->orderBy('hours_before', 'desc')
            ->first() 
            ?? static::getDefault();
    }
}
