<?php
namespace App\Actions;

use App\Constants\Status;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;

class ProcessOrder
{
    use AsAction;
    public string $jobConnection = 'database';
    public string $jobQueue = 'orders';

    public int $jobTries = 1;

    public function handle(Order $order): Order
    {
        if($order->status !== Status::QUEUED)
            throw new \Exception("Order is not queued");

        /**
         *  Process the order
         */

        $order->update([
            "status" => Status::SUCCESS
        ]);
        $order->items()->update(["status" => Status::SUCCESS]);

        NotifyProcessedOrder::dispatch($order);
        return $order->refresh();
    }

    public function asController(Request $request, $orderId)
    {
        $order = Order::where([["id", $orderId], ["status", Status::QUEUED]])->firstOrFail();
        return $this->handle($order);
    }

    public function jsonResponse(Order $order, Request $request): OrderResource
    {
        return new OrderResource($order);
    }

    public static function routes(Router $router)
    {
        $router->get('/order/{order}/process', static::class)->name("order.process");
    }

}
