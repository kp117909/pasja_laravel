<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Events extends Model
{
    use Sortable;
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
        'color',
        'start',
        'end',
    ];

    public $sortable = ['id'];


    public function notification()
    {
        return $this->hasOne(Notifications::class, 'event_id' , 'id');
    }

    use HasFactory;
}
