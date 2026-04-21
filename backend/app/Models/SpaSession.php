<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaSession extends Model
{

    protected $fillable = [
        'type_spa_session_id',
        'client_id',
        'date_debut',
        'date_fin',
        'prix'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class)->where('name', 'SPA');
    }

    public function client()
    {
        return $this->belongsTo(User::class,'client_id')->where('role', 'client');
    }


    public function bills()
    {
        return $this->morphMany(Bill::class, "billable");
    }

    public function TypeSpaSession(){
        return $this->belongsTo(TypeSpaSession::class);
    }

}
