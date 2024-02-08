<?php

namespace App\Actions\Orders;

use App\Models\Order;
use App\Notifications\OrderCreatedNotification;
use Lorisleiva\Actions\Concerns\AsAction;

class SendOrderMail
{
    use AsAction;

    public function handle(Order $order): void
    {
        $order->hmo->notify(new OrderCreatedNotification($order));
    }
}
