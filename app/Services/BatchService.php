<?php

namespace App\Services;

use App\Enums\BatchCriteria;
use App\Models\Batch;
use App\Models\Order;
use Carbon\Carbon;

class BatchService
{

    public function createByEncounterDate(Order $order): Batch
    {
        return $this->createOrUpdate($order, BatchCriteria::ENCOUNTER_DATE);
    }

    public function createOrUpdate(Order $order, BatchCriteria $criteria = BatchCriteria::SUBMISSION_DATE)
    {
        $batchByMonth = ($criteria->value === BatchCriteria::ENCOUNTER_DATE->value) ?
            $order->encounter_date->format('F Y') : Carbon::now()->format('F Y');

        $batch = Batch::updateOrCreate([
            'hmo_id' => $order->hmo_id,
            'month' => $batchByMonth,
            'provider_id' => $order->provider_id,
            'criteria' => $criteria->value,
        ], [
            'hmo_id' => $order->hmo_id,
            'month' => $batchByMonth,
            'provider_id' => $order->provider_id,
            'criteria' => $criteria->value,
        ]);

        $order->batch_id = $batch->id;
        $order->save();

        return $batch;
    }
}
