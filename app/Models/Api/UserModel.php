<?php

namespace App\Models\Api;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
}