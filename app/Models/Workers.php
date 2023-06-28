<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workers  extends \Illuminate\Foundation\Auth\User
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'accessibility',
        'icon_photo',
        'color'
    ];

    protected $casts = [
        'accessibility' => 'array',
    ];
}
