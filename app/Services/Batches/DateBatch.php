<?php

namespace App\Services\Batches;

use App\Interfaces\BatchInterface;
use App\Models\Batch;
use App\Models\Order;
use Illuminate\Support\Carbon;

class DateBatch implements BatchInterface
{
    public static function create(Order $order, string $criteria): void
    {
        $providerId = $order->provider_id;
        $hmoId = $order->hmo_id;
        $batchMonth = $criteria === 'encounter_date' ? Carbon::createFromDate($order->encounter_date)->format('F Y') : Carbon::now()->format('F Y');
        $batch = Batch::where('provider_id', $providerId)
            ->where('hmo_id', $hmoId)
            ->where('month', $batchMonth)
            ->where('criteria', $criteria)
            ->first();

        if (! $batch) {
            $batch = new Batch();
            $batch->provider_id = $providerId;
            $batch->hmo_id = $hmoId;
            $batch->month = $batchMonth;
            $batch->criteria = $criteria;
            $batch->save();
        }

        $order->batch_id = $batch->id;
        $order->save();
    }
}
