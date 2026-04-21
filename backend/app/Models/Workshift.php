<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshift extends Model
{
     protected $fillable = [
            'departement_id',
            'date_debut',
            'date_fin',
            'check_in',
            'check_out'
     ];

     public function departement(){
        return $this->belongsTo(Departement::class);
     }

     public function absences(){
        return $this->hasMany(Absences::class);
     }
}
