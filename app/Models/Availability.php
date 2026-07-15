<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'employee_id','day_of_week','start_time','end_time','slot_duration','is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function employee() { return $this->belongsTo(Employee::class); }
}
