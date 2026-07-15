<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Système']);
    }

    public function actionLabel(): string
    {
        return match($this->action) {
            'login'    => 'Connexion',
            'logout'   => 'Déconnexion',
            'register' => 'Inscription',
            'create'   => 'Création',
            'update'   => 'Modification',
            'delete'   => 'Suppression',
            'approve'  => 'Approbation',
            'reject'   => 'Rejet',
            'confirm'  => 'Confirmation',
            'cancel'   => 'Annulation',
            'payment'  => 'Paiement',
            default    => ucfirst($this->action),
        };
    }

    public function actionColor(): string
    {
        return match($this->action) {
            'login', 'register' => 'success',
            'logout'            => 'secondary',
            'create', 'confirm' => 'info',
            'update', 'approve' => 'warning',
            'delete', 'reject', 'cancel' => 'danger',
            'payment'           => 'success',
            default             => 'primary',
        };
    }
}
