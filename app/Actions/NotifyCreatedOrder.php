<?php
namespace App\Actions;

use App\Notifications\OrderCreated;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;
use \App\Models\Order;

class NotifyCreatedOrder
{
    use AsAction;

    public string $jobConnection = 'database';
    public string $jobQueue = 'notifications';

    public int $jobTries = 1;

    public function handle(Order $order): void
    {
        $order->hmo->notify(new OrderCreated($order));
    }

    public function asController(Request $request, $orderId)
    {
        $this->handle(Order::findOrFail($orderId));
    }

    public function jsonResponse(Request $request): array
    {
        return [];
    }

    public static function routes(Router $router)
    {
        $router->post('/order/{order}/notify-created', static::class);
    }
}
