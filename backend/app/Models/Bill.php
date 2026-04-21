<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        "billable_id",
        "billable_type",
        "montant",
        "is_payed"
    ];

    public function billable()
    {
        return $this->morphTo("billable");
    }
}
