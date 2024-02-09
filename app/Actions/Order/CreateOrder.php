<?php

namespace App\Actions\Order;

use App\Actions\BaseAction;
use App\Actions\Order\ValueObjects\CreateOrderDto;
use App\Events\OrderCreatedEvent;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateOrder extends BaseAction
{
    public function handle(CreateOrderDto $request): void
    {
        OrderCreatedEvent::dispatch(
            Order::query()->create([
                ...$request->toArray(),
                'total' => CalculateOrderItemsTotal::run($request->items)
            ])
        );
    }

    public function asController(CreateOrderRequest $request): \Illuminate\Http\Response|JsonResponse
    {
        $this->handle(CreateOrderDto::fromRequest($request));

        return $this->success(
            __('Order created successfully'),
            statusCode: Response::HTTP_CREATED
        );
    }
}
