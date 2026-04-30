<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
     protected $fillable = [
            'date',
            'prix',
            'client_id',
            'plat_id'
     ];

    public function bills(){
        return $this->morphMany(Bill::class, "billable");
    }

    // user
    public function client(){
        return $this->belongsTo(User::class,'client_id')->where('role', 'client');
    }

    // plats
    public function plats(){
        return $this->belongsToMany(Plat::class);
    }
}
