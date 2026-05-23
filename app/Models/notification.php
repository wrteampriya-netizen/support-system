<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    //
    protected $fillable=[
        'user_id',
        'title',
        'description',
        'tickets_id',
        'is_read'
    ];
}
