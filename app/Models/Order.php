<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
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
