<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
      'items', 'hmo_id', 'order_id', 'batch_id',
    ];
}
