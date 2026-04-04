<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paiment extends Model
{
     protected $filable = [
            'date',
            'prix',
            'reservation_id'

     ];

     public function reservation(){
        return $this->hasOne(Reservation::class);
     }
}
