<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BatchOrder extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'order_id',
    ];
}
