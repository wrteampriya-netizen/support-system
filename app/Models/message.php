<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    //
    protected $table='message';

    protected $fillable = [
        'sender_id',
        'reciever_id',
        'message'
    ];
}
