<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
     protected $fillable = [
        'name',
        'description',
        'is_active'
     ];

     public function workshifts(){
        return $this->hasMany(Workshift::class);
     }

    //relations: tasks
    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function staffs(){
        return $this->hasMany(User::class)->where('role', 'staff');
    }
}
