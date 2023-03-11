<?php

namespace App\Services\Batches;

use App\Enums\HmoBatchCriteria;
use App\Models\Order;

class EncounterDateBatch
{
    public function create(Order $order): void
    {
        DateBatch::create($order, HmoBatchCriteria::ENCOUNTER_DATE->value);
    }
}
