<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class departement extends Model
{
     protected $filable = [
        'name',
        'description',
        'is_active'
     ];
}
