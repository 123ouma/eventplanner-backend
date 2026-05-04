<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\OB_Registration;
use App\Models\OB_Event;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_image',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /* ================= RELATIONS ================= */

    // User hasMany Event (créés par l'admin)
    public function events()
    {
        return $this->hasMany(OB_Event::class, 'created_by');
    }

    // Relation principale pour les inscriptions (OBLIGATOIRE)
    public function registrations()
    {
        return $this->hasMany(OB_Registration::class);
    }

    // Accès direct aux événements inscrits (OPTIONNEL)
    public function registeredEvents()
    {
        return $this->belongsToMany(
            OB_Event::class,
            'ob_registrations',
            'user_id',
            'event_id'
        )->withTimestamps();
    }
}
