<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    //
    protected $table='activity_log';
    protected $fillable = [
        'user_id',
        'action',
        'old_value',
        'new_value',
        'ticket_id'
    ];
}
