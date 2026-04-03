<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
     protected $filable = [];

    public function bills(){
        return $this->morphMany(Bill::class, "billable");
    }
}
