<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
     protected $fillable = [
            'date_enter',
            'date_sortie',
            'prix',
            'user_id',
            'chamber_id',
            'chamber'
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
