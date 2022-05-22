<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarged = ['id'];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }
}
