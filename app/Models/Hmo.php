<?php

namespace App\Models;

use App\Models\Order;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Hmo extends Model
{
    public const HMO_RETRIEVED = 'HMO_RETRIEVED';

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
        'batch_by_encounter_date' => 'boolean',
    ];

    /**
     * Get the orders associated with the Hmo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Boot the Hmo model.
     *
     * This method is called when the Hmo model is being booted.
     * It registers event listeners for the 'creating' and 'updating' events.
     * The 'creating' event listener sets the 'slug' attribute based on the 'name' attribute.
     * The 'updating' event listener updates the 'slug' attribute if the 'name' attribute has changed.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($hmo) {
            $hmo->slug = Str::slug($hmo->name);
        });

        static::updating(function ($hmo) {
            if ($hmo->isDirty('name')) {
                $hmo->slug = Str::slug($hmo->name);
            }
        });
    }


    /**
     * Generate a batch ID for an order.
     *
     * @param  \App\Models\Order  $order
     * @return string
     */
    public function generateBatchId(Order $order): string
    {
        if ($order->batch_id) {
            logger()->info('Order already has a batch ID');

            return $order->batch_id;
        }

        $provider = strtoupper(Str::snake($order->provider));

        $batchDate = $this->batch_by_encounter_date ? $order->encounter_date : $order->created_at;

        try {
            logger()->info('Successfully parsed date');

            $batchDate = Carbon::parse($batchDate);
        } catch (Exception $e) {
            logger()->error('Unable to parse date:' . $e->getMessage());

            return "Error: Unable to parse date";
        }

        $batchIdFormat = config('order.batch_id_format', ':provider-:month-:year');

        $batchId = str_replace(
            [':provider', ':month', ':year'],
            [$provider, $batchDate->format('M'), $batchDate->year],
            $batchIdFormat
        );

        logger()->info('Generated batch ID', ['batch_id' => $batchId]);

        return $batchId;
    }
}
