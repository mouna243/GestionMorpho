<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paiment extends Model
{
     protected $fillable = [
            'date',
            'prix',
            'reservation_id'
     ];

     public function reservation(){
        return $this->belongsTo(Reservation::class);
     }
}
