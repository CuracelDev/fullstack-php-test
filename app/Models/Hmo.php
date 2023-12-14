<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hmo extends Model
{
    use HasFactory;

    const BATCH_CRITERIA_ENCOUNTER_DATE = 'encounter_date';
    const BATCH_CRITERIA_ORDER_DATE = 'order_date';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'code',
        'batch_criteria',
    ];

    /**
     * The orders that has been submitted to this HMO
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * The batches the hmo has to process
     */
    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }
}
