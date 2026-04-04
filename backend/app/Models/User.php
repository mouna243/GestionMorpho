<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
     protected $filable = [
            'name',
            'email',
            'age',
            'CIN',
            'telephon',
            'role',
            'salaire',
            'departement_id',
            'experience',
            'langage',
            'password',
     ];
}
