<?php

namespace App\Actions;

use App\Enums\HmoBatchCriteria;
use App\Mail\NewOrderNotification;
use App\Models\Order;
use App\Services\Batches\EncounterDateBatch;
use App\Services\Batches\SentDateBatch;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrder
{
    use AsAction;

    public function handle($payload)
    {
        $order = Order::create($payload->validated());

        //Create the batch for the order 😇
        $batch = match ($order->hmo->batch_by) {
            HmoBatchCriteria::SUBMIT_DATE->value => new SentDateBatch(),
            default => new EncounterDateBatch(),
        };
        $batch->create($order);

        Mail::to($order->hmo->email)->queue(new NewOrderNotification($order));
    }
}
