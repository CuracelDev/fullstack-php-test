<?php

namespace App\Actions\Order;

use App\Models\Order;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewOrder
{
    use AsAction;

    public function handle(array $newOrder): Order
    {
        return user()->orders()->create($newOrder);
    }
}
