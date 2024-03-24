<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Jobs\BatchOrderJob;
use App\Models\Hmo;
use App\Models\Order;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderService
{

    /**
     * Process provider order
     * @throws ClientErrorException
     */
    public function submitOrder(array $orderDetails)
    {
        $hmo = Hmo::whereCode($orderDetails['hmo_code'])->first();

        $orderItems = $this->prePareOrderItems($orderDetails['items']);

        DB::beginTransaction();
        try {

            $order = Order::create([
                'hmo_id' => $hmo->id,
                'reference' => generateReference(),
                'encounter_date' => $orderDetails['encounter_date'],
                'total_amount' =>  collect($orderItems)->sum('total_price'),
                'items' => $orderItems,
                'provider_name' => $orderDetails['provider_name']
            ]);

            $hmo->notify(new NewOrderNotification($order));

            BatchOrderJob::dispatch($order,$hmo);

            DB::commit();
            return;
        } catch (Throwable $exception) {
            DB::rollBack();
            Log::error($exception);
        }

        throw new ClientErrorException("Unable to submit order. Try again!");

    }

    /**
     * Prepare order items by calculating total price for each item in order
     */
    private function prePareOrderItems($orderItems): array
    {
        return  collect($orderItems)->map(function ($item) {
            return [
                'item' => $item['item'],
                'unit_price' => $item['unit_price'],
                'total_price' =>$item['unit_price'] * $item['quantity'],
                'quantity' => $item['quantity']
            ];
        })->all();
    }
}
