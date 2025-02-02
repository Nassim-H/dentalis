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

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_Verified',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
