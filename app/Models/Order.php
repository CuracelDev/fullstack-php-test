<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $casts = [
        'items' => 'array',
    ];

    protected $guarded = ['id'];

    /**
    * The "booted" method of the model.
    */
    protected static function booted(): void
    {
        static::creating(function (self $order) {
            $order->batch_identifier = $order->generateBatchIdentifier();
            $order->amount = $order->calculateTotalAmount();
        });
    }

    public function hmo(): BelongsTo
    {
        return $this->belongsTo(Hmo::class);
    }

     /**
     * Generate batch identifier for order
     *
     * @return string
     */
    public function generateBatchIdentifier(): string
    {
        if($this->batch_identifier){
            return $this->batch_identifier;
        }

        if ($this->hmo->batch_criteria === Hmo::BATCH_CRITERIA_ORDER_DATE) {    
            $batchDate = $this->created_at;
        } else {
            $batchDate = $this->encounter_date;
        }

        $batchDate = Carbon::parse($batchDate)->format('M Y');

        return "{$this->provider_name} {$batchDate}";
    }


    /**
     * Calculate total amount for order
     *
     * @return float
     */
    public function calculateTotalAmount(): float
    {
        $total = 0;

        foreach ($this->items as $item) {
            $item['sub_total'] = $item['unit_price'] * $item['quantity'];

            $total += $item['sub_total'];
        }

        return $total;
    }
}
