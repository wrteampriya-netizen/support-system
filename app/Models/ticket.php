<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'subject',
        'description',
        'priority',
        'category',
        'status',
        'attachment', 
        'customer_id'
    ];

    public function agent()
{
    return $this->belongsTo(Agent::class, 'assign_to');
}
public function tickets(){
    return $this->hasMany(ticket::class,'assign_to');
}
public function assign(){
   return $this->belongsTo(User::class,'assign_to');
}
}
