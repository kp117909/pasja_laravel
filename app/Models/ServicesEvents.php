<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesEvents extends Model
{
    protected $fillable = [
        'id_service',
        'id_event',
        'id_client',
        'id_worker',
    ];

    use HasFactory;
}
