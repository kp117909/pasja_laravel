<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = [
        'id',
        'title',
        'name_c',
        'surname_c',
        'phone_c',
        'name_w',
        'surname_w',
        'overal_price',
        'start',
        'end',
    ];
    use HasFactory;
}
