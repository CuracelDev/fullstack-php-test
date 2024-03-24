<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;


class OrderController extends Controller
{

    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Submit order
     * @throws ClientErrorException
     */
    public function store(SubmitOrderRequest  $request):JsonResponse
    {
        $this->orderService->submitOrder($request->validated());

        return successResponse();
    }
}
