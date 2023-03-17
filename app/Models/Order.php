<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "hmo_id",
        "provider_name",
        "date",
        "items",
    ];

    protected $casts = [
        "items" => "array",
    ];
}
