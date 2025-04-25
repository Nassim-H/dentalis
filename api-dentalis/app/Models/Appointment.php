<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'client_id',
        'doctor_id',
        'date',
        'duration',
        'description',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}