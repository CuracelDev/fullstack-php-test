<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'items' => 'json',
    ];

    protected $fillable = [
        'items',
        'hmo_id',
        'provider_name',
        'encounter_date',
        'total_amount',
        'items',
        'reference'
    ];
}
