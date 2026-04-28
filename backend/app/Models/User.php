<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
     use HasApiTokens;
     protected $casts = [
        'experiences' => 'array',
        'langages' => 'array',
     ];

     protected $fillable = [
            'name',
            'email',
            'age',
            'CIN',
            'telephon',
            'role',
            'salaire',
            'departement_id',
            'experiences',
            'langages',
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
