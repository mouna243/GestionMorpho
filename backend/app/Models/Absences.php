<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
    protected $filable = [
        'workshit_id',
        'user_id',
        'is_justified',
        'pdf'
    ];

}
