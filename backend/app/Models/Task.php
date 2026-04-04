<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
     protected $filable = [
            'name',
            'description',
            'is_completed',
            'departement_id'
     ];
}
