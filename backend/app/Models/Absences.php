<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
    protected $fillable = [
        'workshift_id',
        'staff_id',
        'is_justified',
        'pdf'
    ];

    public function staff(){
        return $this->belongsTo(User::class, 'staff_id')->where('role', 'staff');
    }

    public function workshift(){
        return $this->belongsTo(Workshift::class);
    }

}
