<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'hmo_id',
        'batch_id',
        'items',
        'encountered_at',
    ];

    protected $casts = [
        'items' => 'json',
    ];

    protected $dates = [
        'encountered_at',
    ];

    public function hmo(): BelongsTo
    {
        return $this->belongsTo(Hmo::class);
    }
}
