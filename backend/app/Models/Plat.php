<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    protected $filable = [
        'name',
        'image',
        'discription',
        'is_available'
    ];

    // commandes
    public function commandes(){
        return $this->belongsToMany(Commande::class);
    }
}
