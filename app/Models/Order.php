<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'items' => 'array',
        'encounter_date' => 'datetime'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Hmo::class);
    }
}
