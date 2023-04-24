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

    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $order) {
            $order->batch_id = $order->hmo->generateBatchId($order);
        });
    }

    public function hmo(): BelongsTo
    {
        return $this->belongsTo(Hmo::class);
    }
}
