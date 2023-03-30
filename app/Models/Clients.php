<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Clients extends Authenticatable
{
    protected $fillable = [
        'id',
        'login',
        'password',
        'first_name',
        'last_name',
        'phone',
    ];

    protected $hidden = [
        'password',
    ];
    use HasFactory;
}
