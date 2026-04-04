<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     protected $filable = [
            'name',
            'description',
            'is_completed',
            'departement_id'
     ];

     public function departement(){
        return $this->belongsTo(Departement::class);
     }
}
