<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class departement extends Model
{
     protected $filable = [
        'name',
        'description',
        'is_active',
        'workshift_id'
     ];

     public function workshifts(){
        return $this->hasMany(Workshift::class);
     }

    //relations: tasks
    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function user(){
        return $this->hasMany(User::class)->where('role', 'staff');
    }
}
