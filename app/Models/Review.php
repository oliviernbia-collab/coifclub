<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'reservation_id','client_id','employee_id','service_id',
        'rating','comment','is_published',
    ];

    protected $casts = ['is_published' => 'boolean'];

    public function reservation() { return $this->belongsTo(Reservation::class); }
    public function client()      { return $this->belongsTo(User::class, 'client_id'); }
    public function employee()    { return $this->belongsTo(Employee::class); }
    public function service()     { return $this->belongsTo(Service::class); }

    public function getStarsAttribute(): string
    {
        return str_repeat('⭐', $this->rating);
    }
}
