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
        "chamber_type_id",
        "reservation_id"
     ];

     // relations
     public function chamber_type(){
        return $this->belongsTo(ChamberType::class);
     }

     public function reservations(){
        return $this->hasMany(Reservation::class);
     }
}
