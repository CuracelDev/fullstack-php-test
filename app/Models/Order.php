<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $casts = [
        'items' => 'array',
    ];

    protected $guarded = ['id'];

    public function hmo(): BelongsTo
    {
        return $this->belongsTo(Hmo::class);
    }
}
