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
            'service_id'
     ];

    public function bills(){
        return $this->morphMany(Bill::class, "billable");
    }
}
