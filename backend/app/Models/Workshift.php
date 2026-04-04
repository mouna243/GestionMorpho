<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshift extends Model
{
     protected $filable = [
            'departement_id',
            'date_debut',
            'date_fin',
            'check_in',
            'check_out'
     ];
}
