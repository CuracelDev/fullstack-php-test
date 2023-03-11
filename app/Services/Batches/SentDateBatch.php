<?php

namespace App\Services\Batches;

use App\Enums\HmoBatchCriteria;
use App\Models\Order;

class SentDateBatch
{
    public function create(Order $order): void
    {
        DateBatch::create($order, HmoBatchCriteria::SUBMIT_DATE->value);
    }
}
