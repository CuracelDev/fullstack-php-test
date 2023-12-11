<?php

namespace App\Actions;

use App\Enums\BatchStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Mail\BatchStatusMail;
use App\Mail\OrderStatusMail;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class ProcessBatchedOrdersAction
{
    use AsAction;

    public function handle(Batch $batch)
    {
        DB::transaction(function () use ($batch) {
            $batch->update(['status' => BatchStatusEnum::PROCESSED()->value]);
            $batch->order->update(['status' => OrderStatusEnum::PROCESSED()->value]);

        });

        dispatch(function () use ($batch){
            Mail::to($batch->hmo->email)
                ->send(
                    new BatchStatusMail(
                        "Batch Status for {$batch->identifier}",
                        $batch
                    )
                );

            Mail::to($batch->order->provider)
                ->send(
                    new OrderStatusMail(
                        "Order Status for  {$batch->order->id}",
                        "Your order has been processed successfully"
                    )
                );
        });

    }
}
