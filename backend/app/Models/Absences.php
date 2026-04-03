<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
    protected $filable = [
        'user_id',
        'date',
        'heure_debut',
        'heure_fin',
        '',
        'statut',
        'pdf'
    ];

}
