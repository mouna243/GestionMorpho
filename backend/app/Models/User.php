<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
     protected $filable = [
            'name',
            'email',
            'age',
            'CIN',
            'telephon',
            'role',
            'salaire',
            'departement_id',
            'experience',
            'langage',
            'password',
     ];
     // reservations , spa_sessions, commandes , departements , absences

     public function departements(){
        return $this->belongsTo(Departement::class);
     }

     public function reservations(){
        return $this->hasMany(Reservation::class);
     }

     public function spaSessions(){
        return $this->hasMany(SpaSession::class);
     }

     public function commandes(){
        return $this->hasMany(Commande::class);
     }

     public function absences(){
        return $this->hasMany(Absences::class);
     }
}
