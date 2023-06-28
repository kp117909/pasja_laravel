<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'event_id',
        'client_id',
    ];

    public function event()
    {
        return $this->belongsTo(Events::class, 'event_id' , 'id');
    }

    public function worker()
    {
        return $this->belongsTo(Workers::class, 'worker_id' ,'id');
    }

}
