<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hmo extends Model
{
    const BATCH_CRITERIA_ENCOUNTER_DATE = 'encounter_date';
    const BATCH_CRITERIA_ORDER_DATE = 'order_date';

    protected $guarded = ['id'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
