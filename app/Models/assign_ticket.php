<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class assign_ticket extends Model
{
    //
     protected $table = 'assign_tickets';
    protected $fillable = ['tickets_id', 'user_id', 'status', 'created_at', 'updated_at'];

}
