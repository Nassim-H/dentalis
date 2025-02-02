<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apt_Doctor extends Model
{
    
    public $timestamps = false;  // Désactive la gestion des timestamps pour ce modèle pivot

    protected $table = 'apt_doctors';

    protected $filable = [
        'id_apt',
        'id_doctors',
    ];


}
