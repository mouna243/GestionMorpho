<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
     protected $filable = [
            'date_enter',
            'date_sortie',
            'prix',
            'client_id',
            'chamber_id'
     ];

     // relation : chamber , user , paiment

     public function chamber(){
        return $this->belongsTo(Chamber::class);
     }

     public function client(){
        return $this->belongsTo(User::class, 'client_id')->where('role', 'client');
     }

     public function paiments(){
        return $this->hasOne(Paiment::class);
     }

}
