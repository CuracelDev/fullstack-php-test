<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hmo extends Model
{
    protected $casts = [
        'batch_by_encounter_date' => 'boolean',
    ];

    protected $guarded = ['id'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public static function findByCode(string $code): ?self
    {
        return static::where('code', $code)->first();
    }

    /**
     * Generate the batch ID for an order based on the HMO's preferences.
     *
     * @param Order $order
     *
     * @return string
     */
    public function generateBatchId(Order $order): string
    {
        if ($order->batch_id) {
            return $order->batch_id;
        }

        $provider = strtoupper($order->provider);

        $batchDate = $this->batch_by_encounter_date ? $order->encounter_date : $order->created_at;
        $batchDate = Carbon::parse($batchDate);

        $batchMonth = $batchDate->format('M');
        $batchYear = $batchDate->year;

        return "{$provider}-{$batchMonth}-{$batchYear}";
    }
}
