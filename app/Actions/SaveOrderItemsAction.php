<?php

namespace App\Actions;

use App\DTOs\Models\HMOData;
use App\DTOs\Models\OrderData;
use App\DTOs\Requests\SaveOrderItems\OrderItemsData;
use App\DTOs\Requests\SaveOrderItems\SaveOrderItemsData;
use App\DTOs\Responses\ApiResponseSuccess;
use App\Exceptions\InvalidHMOException;
use App\Http\Requests\SaveOrderItemRequest;
use App\Models\Batch;
use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class SaveOrderItemsAction
{
    use AsAction;

    public function handle(SaveOrderItemsData $orderItemsData): void
    {

        $hmo = Hmo::query()->where('code', $orderItemsData->hmo)
            ->first();

        $hmoData = new HMOData($hmo->toArray());

        DB::transaction(function () use ($orderItemsData, $hmoData) {



            $order = Order::query()->create(
                [
                    'items' => $this->buildItemData($orderItemsData),
                    'provider_name' => $orderItemsData->providerName,
                    'hmo_id' => $hmoData->id,
                    'total_price' => $this->totalPrice($orderItemsData->orderItems)
                ]
            );

            $orderData = new OrderData($order->toArray());

            Provider::query()
                ->firstOrCreate([
                    'name' => $orderItemsData->providerName,
                ]);

            $toBeProcessedAt = $this->processBatchAt(
                $hmoData,
                $orderData->created_at,
                $orderItemsData->encounterDate
            );
            $date = Carbon::parse($toBeProcessedAt);

            Batch::query()
                ->create([
                    'identifier' => $orderItemsData->providerName . $date->format('m') . $date->format('y'),
                    'order_id' => $order->id,
                    'hmo_id' => $hmoData->id,
                    'process_batch_at' => $toBeProcessedAt
                ]);
        });

    }

    public function asController(SaveOrderItemRequest $request)
    {
        $this->handle(
            new SaveOrderItemsData($request->all())
        );

        return ApiResponseSuccess::make(
            'Order items submitted successfully'
        );
    }

    protected function buildItemData(SaveOrderItemsData $data): array
    {
        $items = [];

        foreach ($data->orderItems as $orderItem) {
            $items = [
                'name' => $orderItem->name,
                'quantity' => $orderItem->quantity,
                'unit_price' => $orderItem->unit_price,
            ];
        }
        return $items;
    }

    protected function totalPrice(OrderItemsData $orderItemsData)
    {
        $total = 0;

        foreach ($orderItemsData as $orderItemsDatum) {
            $total += $orderItemsDatum->quantity * $orderItemsDatum->unit_price;
        }

        return $total;
    }

    protected function processBatchAt(
        HMOData $HMOData,
        string  $sentDate,
        string  $encounterDate

    ): string
    {
        if ($HMOData->batchRequirement == 'sent_date') {
            return $sentDate;
        }

        return $encounterDate;


    }

}
