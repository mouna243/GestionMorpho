<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $filable = [
        "billable",
        "montant",
        "is_payed"
    ];

    public function billable()
    {
        return $this->morphTo("billable");
    }
}
