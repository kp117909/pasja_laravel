<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;


class Users extends Authenticatable
{

    protected $fillable = [
        'id',
        'login',
        'password',
        'first_name',
        'last_name',
        'phone',
        'adress',
        'postcode',
        'icon_photo',
    ];

    protected $hidden = [
        'password',
    ];
    use HasFactory;
}
