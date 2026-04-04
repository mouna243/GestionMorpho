<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaSession extends Model
{

    protected $filable = [
        'date_debut',
        'date_fin',
        'prix',
        'type',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class)->where('name', 'SPA');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->where('role', 'client');
    }


    public function bills()
    {
        return $this->morphMany(Bill::class, "billable");
    }

}
