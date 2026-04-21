<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeSpaSession extends Model
{
    protected $fillable =[
        'name',
        'discription',
        'prix',
        'status'
    ];

    public function spaSessions(){
        return $this->hasMany(SpaSession::class);
    }
    
}
