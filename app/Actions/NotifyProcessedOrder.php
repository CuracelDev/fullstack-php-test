<?php
namespace App\Actions;

use App\Notifications\OrderProcessed;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;
use \App\Models\Order;

class NotifyProcessedOrder
{
    use AsAction;

    public string $jobConnection = 'database';
    public string $jobQueue = 'notifications';

    public int $jobTries = 1;

    public function handle(Order $order): void
    {
        $order->hmo->notify(new OrderProcessed($order));
    }

    public function asController(Request $request, $orderId)
    {
        $this->handle(Order::findOrFail($orderId));
    }


    public static function routes(Router $router)
    {
        $router->post('/order/{order}/notify-processed', static::class);
    }
}
