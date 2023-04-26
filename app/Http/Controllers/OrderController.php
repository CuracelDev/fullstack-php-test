<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrder;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(OrderRequest $request): JsonResponse
    {
        $order = Order::create($request->validated());

        CreateOrder::dispatchAfterResponse($order);

        return response()->json([
            'status' => true,
            'message' => "Order Created!",
            'data' => $order
        ]);
    }
}
