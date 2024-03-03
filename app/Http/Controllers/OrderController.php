<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\FilterOrderRequest;
use App\Http\Resources\OrderApiResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterOrderRequest $request)
    {
        $filterQuery = $request->validated();
        $results = Order::with(['hmo'])->filterBy($filterQuery)->cursor();

        $formattedResults = [];

        foreach ($results as $order) {
            $formattedResults[$order->user_month_year][] = new OrderApiResource($order);
        }

        return response()->json($formattedResults, 200, []);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrderRequest $request)
    {
        $order = auth()->user()->orders()->create($request->validated());

        return response()->json([
            'message' => "Order created successfully!",
            'order' => $order
        ], 200, []);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->only('is_processed'));

        return response()->json(['is_processed' => true], 200, []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(['message' => 'order deleted successfully!'], 200, []);
    }
}
