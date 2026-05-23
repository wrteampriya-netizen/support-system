<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    //
    protected $table='team';
    protected $fillable = [
        'name',
        'owner_id',
        'description'

    ];
    public function members() {
        return $this->belongsToMany(User::class);
    }
    public function leader(){
       return $this->belongsTo(User::class,'owner_id');
    }
}
