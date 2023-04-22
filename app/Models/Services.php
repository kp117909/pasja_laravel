<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Services extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'service_name',
        'price',
        'img',
    ];

    public $sortable = ['id'];
}
