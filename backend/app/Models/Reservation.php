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

     // relation : chamber , user , paiment

     public function chamber(){
        return $this->belongsTo(Chamber::class);
     }

     public function user(){
        return $this->belongsTo(User::class)->where('role', 'client');
     }

     public function paiment(){
        return $this->belongsTo(Paiment::class);
     }

}
