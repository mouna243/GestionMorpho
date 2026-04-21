<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
     protected $fillable = [
            'name',
            'discreption',
            'prix',
            'time_start',
            'time_end',
            'is_available'
     ];

     //commandes
     public function commandes(){
        return $this->hasMany(Commande::class);
     }

     public function spaSessions(){
        return $this->hasMany(SpaSession::class);
     }
     
}
