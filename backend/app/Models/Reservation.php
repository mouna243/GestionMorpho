<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
     protected $filable = [
            'date_enter',
            'date_sortie',
            'chamber',
            'prix',
            'user_id',
            'chamber_id'
     ];
}
