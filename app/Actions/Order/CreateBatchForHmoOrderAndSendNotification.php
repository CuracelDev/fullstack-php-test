<?php

namespace App\Actions\Order;

use App\Actions\BaseAction;
use App\Events\OrderCreatedEvent;
use App\Models\HmoBatch;
use App\Models\Order;
use App\Notifications\OrderCreatedNotification;
use Exception;

class CreateBatchForHmoOrderAndSendNotification extends BaseAction
{
    public function handle(Order $order): void
    {
        $batchIdentifier = GenerateBatchIdentifier::run($order);

        $batch = HmoBatch::query()
            ->firstOrCreate([
                'name' => $batchIdentifier,
                'hmo_id' => $order->hmo->id
            ]);

        $order->updateQuietly(['hmo_batch_id' => $batch->id]);

        try {
            $order->hmo->notify(
                new OrderCreatedNotification(
                    batchName: $batch->name,
                    provider: $order->provider,
                    hmoName: $order->hmo->name)
            );
        } catch (Exception) {}
    }

    public function asListener(OrderCreatedEvent $event): void
    {
        $this->handle($event->order);
    }
}
