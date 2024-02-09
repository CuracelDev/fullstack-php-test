<?php

namespace App\Actions\Order;

use App\Actions\BaseAction;
use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Support\Carbon;

class GenerateBatchIdentifier extends BaseAction
{
    public function handle(Order $order): string
    {
        $batchUsing = match($order->hmo->{'batch_preference'}) {
            Hmo::BATCH_PREFERENCE_ENCOUNTER_DATE => $order->getAttribute('encounter_date'),
            Hmo::BATCH_PREFERENCE_CREATED_DATE => $order->getAttribute('created_at'),
            default => null
        };

        return "{$order->getAttribute('provider')} " . Carbon::parse($batchUsing)->format('M Y');
    }
}
