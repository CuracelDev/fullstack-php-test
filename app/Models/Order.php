<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'items' => []
    ];
    protected $fillable = [
        'items',
        'provider_id',
        'hmo_id',
        'total_price'
    ];
}
