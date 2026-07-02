<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
     protected $table = 'user_roles';
    protected $fillable = [
        'name',
        'role'
    ];
}