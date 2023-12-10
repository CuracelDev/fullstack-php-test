<?php

namespace App\Actions;

use App\DTOs\Requests\SaveOrderItems\OrderItemsData;
use Lorisleiva\Actions\Concerns\AsAction;

class BuildOrderItemDataAction
{
    use AsAction;

    public function handle($orderItems): array
    {
        $items = [];

        foreach ($orderItems as $orderItem) {
            $items[] = [
                'name' => $orderItem->name,
                'quantity' => $orderItem->quantity,
                'unit_price' => $orderItem->unit_price,
                'sub_total' => $orderItem->quantity * $orderItem->unit_price
            ];
        }
        return $items;
    }
}
