<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamberType extends Model
{
     protected $fillable = [
            'name',
            'description',
            'prix',
            'is_available',
     ];

     public function chambers(){
        return $this->hasMany(Chamber::class);
     }
}
