<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hmo extends Model
{
    protected $guarged = ['id'];
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'orders')->distinct();
    }
}
