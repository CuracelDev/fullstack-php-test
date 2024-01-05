<?php
namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;
use \App\Models\Order;
use \App\Dto\CreateOrderDto;
use \App\Http\Resources\OrderResource;

class CreateOrder
{
    use AsAction;

    public function handle(CreateOrderDto $orderDto): Order
    {
        $order = Order::create($orderDto->order->asArray());
        $order->items()->createMany($orderDto->items->asArray());

        NotifyCreatedOrder::withChain([
            BatchOrder::makeJob($order),
        ])->dispatch($order);

        return $order->refresh();
    }

    public function asController(Request $request): Order
    {
        return $this->handle((new CreateOrderDto())->fromRequest($request));
    }

    public function jsonResponse(Order $order, Request $request): OrderResource
    {
        return new OrderResource($order);
    }

    public function rules(): array
    {
        return [
            'provider_name' => ['required', 'string'],
            'hmo_code' => ['required', 'exists:hmos,code'],
            'encounter_date' => ['required', 'date'],
            'items' => ['required','array'],
            'items.*.name' => ['required', 'string'],
            'items.*.price' => ['required', 'numeric'],
            'items.*.quantity' => ['required', 'numeric']
        ];
    }


    public static function routes(Router $router)
    {
        $router->post('/order', static::class)->name("order.create");
    }
}
