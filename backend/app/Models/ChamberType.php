<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamberType extends Model
{
     protected $filable = [
            'name',
            'description',
            'is_available',
     ];
}
