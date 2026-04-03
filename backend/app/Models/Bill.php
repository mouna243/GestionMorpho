<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{


    public function billable(){
        return $this->morphTo("billable");
    }
}
