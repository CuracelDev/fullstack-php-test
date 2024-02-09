<?php

namespace App\Actions\Order;

use App\Actions\BaseAction;
use Illuminate\Support\Collection;

class CalculateOrderItemsTotal extends BaseAction
{
    public function handle(array $items): int
    {
        return Collection::make($items)
            ->reduce(fn ($total, $item) => $total + ($item['quantity'] * $item['price']), 0);
    }
}
