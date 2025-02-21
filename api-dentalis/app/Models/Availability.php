<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'doctor_id',
        'start_datetime',
        'end_datetime',
    ];
}
