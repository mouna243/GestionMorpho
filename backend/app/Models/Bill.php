<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $filable = [
        "billable",
        "montant"
    ];

    public function billable()
    {
        return $this->morphTo("billable");
    }
}
