<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
    protected $filable = [
        'workshit_id',
        'user_id',
        'is_justified',
        'pdf'
    ];

    public function user(){
        return $this->belongsTo(User::class)->where('role', 'staff');
    }

    public function workshift(){
        return $this->belongsTo(Workshift::class);
    }

}
