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
        'client_id',
        'name_w',
        'surname_w',
        'worker_id',
        'worker_icon',
        'overal_price',
        'start',
        'end',
    ];
    use HasFactory;
}
