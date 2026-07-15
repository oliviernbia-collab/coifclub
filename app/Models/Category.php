<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'nom',
        'description',
    ];

    /**
     * Relation avec les services
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}