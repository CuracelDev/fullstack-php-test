<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrder;
use App\Http\Requests\OrderRequest;
use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(OrderRequest $request): JsonResponse
    {
        $input = $request->validated();

        $input['hmo_id'] = (Hmo::whereCode($input['hmo_code'])->first())->id;
        $input['provider_id'] = (Provider::whereCode($input['provider_code'])->first())->id;

        $order = Order::create($input);

        CreateOrder::dispatchAfterResponse($order);

        return response()->json([
            'status' => true,
            'message' => "Order Created!",
            'data' => $order
        ]);
    }
}
