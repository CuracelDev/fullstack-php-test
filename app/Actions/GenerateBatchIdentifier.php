<?php

namespace App\Actions;

use App\Models\Hmo;
use App\Models\Order;
use Carbon\Carbon;

class GenerateBatchIdentifier extends BaseAction
{
    public function handle(Order $order): string
    {
        $batchDate = '';

        if ($order->hmo->batch_criteria === Hmo::BATCH_CRITERIA_ORDER_DATE) {    
            $batchDate = $order->created_at;
        } else {
            $batchDate = $order->encounter_date;
        }

        return "$order->provider_name " . Carbon::parse($batchDate)->format('M Y');
    }
}
