<?php

namespace App\Http\Controllers;

use App\Actions\Order\CreateNewOrder;
use App\Actions\Order\GetOrderList;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\FilterOrderRequest;
use App\Http\Resources\OrderApiResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  FilterOrderRequest  $request
     * @return JsonResponse
     */
    public function index(FilterOrderRequest $request, GetOrderList $getOrderList): JsonResponse
    {
        $orders = $getOrderList->handle($request->validated());
        return response()->json($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderRequest  $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request, CreateNewOrder $createNewOrder): JsonResponse
    {
        $order = $createNewOrder->handle($request->validated());

        return response()->json([
            'message' => 'Order created successfully!',
            'order' => new OrderApiResource($order)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Order  $order
     * @return JsonResponse
     */
    public function update(Order $order): JsonResponse
    {
        $order->update(request()->only('is_processed'));

        return response()->json(['is_processed' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order  $order
     * @return JsonResponse
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully!'], 200);
    }

}
