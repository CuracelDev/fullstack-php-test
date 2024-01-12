<?php

namespace App\Models;

use App\Models\Hmo;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The pending status of an order.
     */
    public const PENDING_STATUS = 'pending';

    /**
     * The successful status of an order.
     */
    public const SUCCESSFUL_STATUS = 'successful';

    /**
     * The failed status of an order.
     */
    public const FAILED_STATUS = 'failed';

    /**
     * The created status of an order.
     */
    public const CREATED_STATUS = 'ORDER_CREATED';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'items' => 'array',
    ];

    /**
     * The "booted" method is called when the Order model is booted.
     * It registers a creating event listener that generates a batch ID for the order.
     *
     * @return void
     */
    protected static function booted()
    {
        logger()->info('Order model booted');

        static::creating(function ($order) {
            $order->batch_id = $order->hmo->generateBatchId($order);
        });
    }

    /**
     * Get the hmo that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hmo()
    {
        return $this->belongsTo(Hmo::class);
    }
}
