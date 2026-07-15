<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'nom',
        'description',
    ];

    /**
     * Une catégorie peut avoir plusieurs services (ou prestations)
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'categorie_id');
    }
}