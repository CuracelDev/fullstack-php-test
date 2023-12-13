<?php

namespace App\Actions;

use App\Events\OrderSubmitted;
use App\Mail\OrderBatchEmail;
use App\Models\Batch;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class BatchOrder
{
    use AsAction;

    public function handle(Order $order)
    {
        $batchName = GenerateBatchIdentifier::run($order);

        $batch = Batch::firstOrCreate(['name' => $batchName, 'hmo_id' => $order->hmo->id]);

        $order->batch_id = $batch->id;

        $order->save();

        Mail::to($order->hmo->email)
                ->send(new OrderBatchEmail(
                   "New Batch Alert: {$batchName}",
                   "{$order->provider_name} has placed an order and it has been batched with identifier: {$batchName}"
                )
        );
    }

    public function asListener(OrderSubmitted $event): void
    {
        $this->handle($event->order);
    }
}
