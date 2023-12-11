<?php

namespace App\Actions;

use App\DTOs\Models\HMOData;
use App\DTOs\Requests\SaveOrderItems\SaveOrderItemsData;
use App\Enums\BatchRequirementEnum;
use App\Enums\BatchStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Mail\BatchStatusMail;
use App\Mail\OrderStatusMail;
use App\Models\Batch;
use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class ProcessOrderAction
{
    use AsAction;

    public function handle(SaveOrderItemsData $savedOrderItemsData, Hmo $hmo)
    {
        DB::transaction(function () use ($savedOrderItemsData, $hmo) {

            $hmoData = new HMOData($hmo->toArray());

            // Save Provider
            $provider = Provider::query()
                ->firstOrCreate([
                    'name' => $savedOrderItemsData->providerName,
                ]);

            // Save Order
            $order = Order::query()->create(
                [
                    'items' => BuildOrderItemDataAction::run($savedOrderItemsData->orderItems),
                    'provider_id' => $provider->id,
                    'hmo_id' => $hmoData->id,
                    'total_price' => GetTotalPriceAction::run($savedOrderItemsData->orderItems),
                    'status' => OrderStatusEnum::PENDING()->value
                ]
            );


            $toBeProcessedAt = $this->processBatchAt(
                $hmoData,
                $order->created_at,
                $savedOrderItemsData->encounterDate
            );

            $date = Carbon::parse($toBeProcessedAt);

            $identifier = sprintf("%s %s %s", $savedOrderItemsData->providerName, $date->format('M'), $date->format('Y'));

            // Save Batch
            $batch = Batch::query()
                ->create([
                    'identifier' => $identifier,
                    'order_id' => $order->id,
                    'hmo_id' => $hmoData->id,
                    'process_batch_at' => $toBeProcessedAt,
                    'status' => BatchStatusEnum::PENDING()->value
                ]);

            //send email to the provider notifying them of the sent order.
            dispatch(function () use ($provider, $hmo, $order, $identifier) {
                Mail::to($provider)
                    ->send(
                        new OrderStatusMail(
                            "Order status for {$order->id}",
                            "Your Order has been put to batch"
                        )
                    );

                Mail::to($hmo)
                    ->send(
                        new BatchStatusMail(
                            "Batch status for {$identifier}",
                            " {$provider->name} has placed a new order for batch: {$identifier}"
                        )
                    );

            });

        });

    }

    protected function processBatchAt(
        HMOData $HMOData,
        string  $sentDate,
        string  $encounterDate

    ): string
    {
        if ($HMOData->batch_requirement == BatchRequirementEnum::SENT_DATE()->value) {
            return $sentDate;
        }

        return $encounterDate;


    }
}
