<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\FilterOrderRequest;
use App\Http\Resources\OrderApiResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  FilterOrderRequest  $request
     * @return JsonResponse
     */
    public function index(FilterOrderRequest $request): JsonResponse
    {
        $orders = Order::with('hmo')->filterBy($request->validated())->get();

        $formattedResults = $this->formatOrders($orders);

        return response()->json($formattedResults, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderRequest  $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $order = auth()->user()->orders()->create($request->validated());

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

    /**
     * Format the orders for API response.
     *
     * @param  Collection  $orders
     * @return Collection
     */
    private function formatOrders(Collection $orders): Collection
    {
        return $orders->groupBy('user_month_year')->map(function ($groupedOrders) {
            return $groupedOrders->map(function ($order) {
                return new OrderApiResource($order);
            });
        });
    }
}
