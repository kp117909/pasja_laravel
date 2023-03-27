<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'phone',
    ];
    use HasFactory;
}
