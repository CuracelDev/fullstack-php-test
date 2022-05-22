<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $guarged = ['id'];
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function hmos()
    {
        return $this->belongsToMany(Hmo::class, 'orders')->using(Order::class);
    }
}
