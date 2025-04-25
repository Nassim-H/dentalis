<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\CustomMustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasApiTokens, Notifiable, CustomMustVerifyEmail;

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'doctor',
        'admin',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'doctor' => 'boolean',
        'admin' => 'boolean',
    ];

    // Si l'utilisateur est un client, ses RDV pris
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'client_id');
    }

    // Si l'utilisateur est un docteur, les RDV qu'il reçoit
    public function receivedAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    // Disponibilités pour un docteur
    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'doctor_id');
    }
}
