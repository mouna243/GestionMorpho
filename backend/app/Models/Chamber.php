<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chamber extends Model
{
     protected $filable = [
        "name",
        "image",
        "description",
        "is_available",
        "chamber_type_id"
     ];
}
