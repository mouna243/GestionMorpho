<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
     protected $filable = [
            'date',
            'date_sortie',
            'prix',
            'client_id',
            'service_id',
            'plat_id'
     ];

    public function bills(){
        return $this->morphMany(Bill::class, "billable");
    }

    // service
    public function service(){
        return $this->belongsTo(Service::class)->where('name', 'Restoration');
    }
    // user
    public function user(){
        return $this->belongsTo(User::class)->where('role', 'client');
    }

    // plats
    public function plats(){
        return $this->belongsToMany(Plat::class);
    }
}
