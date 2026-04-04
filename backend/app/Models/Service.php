<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
     protected $filable = [
            'name',
            'discreption',
            'prix',
            'time_start',
            'time_end',
            'is_available'
     ];
}
