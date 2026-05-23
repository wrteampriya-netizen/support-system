<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
     use Notifiable;
    //
     protected $table = 'agents';
        protected $guarded = [];

}
