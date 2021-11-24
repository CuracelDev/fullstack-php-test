<?php

namespace App\Actions\Orders;

use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use App\Http\Resources\OrderResource;
use App\Http\Requests\CreateOrderRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrder
{
    use AsAction;
    
    public function handle(array $data)
    {   
        $hmo = Hmo::where('code', $data['hmoCode'])->first();
        $provider = Provider::where('name', $data['provider'])->first();

        $order = new Order;
        $order->items = $data['orderItems'];
        $order->hmo_id = $hmo->id;
        $order->provider_id = $provider->id;
        $order->encounter_date = $data['encounterDate'];

        $order->save();

        return $order;
    }

    public function asController(CreateOrderRequest $request)
    {
        return $this->handle($request->validated());
    }

    public function jsonResponse(Order $order)
    {
        return new OrderResource($order);
    }
}