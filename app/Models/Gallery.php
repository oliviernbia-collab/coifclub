<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery';

    protected $fillable = [
        'salon_id',
        'employee_id',
        'service_id',
        'before_image',
        'after_image',
        'caption',
        'is_published',
    ];

    /**
     * Employé
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}