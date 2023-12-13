<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_name',
        'items',
        'hmo_id',
        'order_amount',
        'encounter_date',
        'batch_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'items' => 'array',
        'encounter_date' => 'datetime'
    ];

    /**
     * Get the HMO that the order is submitted to.
     */
    public function hmo(): BelongsTo
    {
        return $this->belongsTo(Hmo::class);
    }
}
