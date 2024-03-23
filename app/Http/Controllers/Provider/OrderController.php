<?php

namespace App\Http\Controllers\Provider;

use App\Exceptions\ClientErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\SubmitOrderRequest;
use App\Services\ProviderOrderService;
use Illuminate\Http\JsonResponse;


class OrderController extends Controller
{

    private  $providerOrderService;

    public function __construct(ProviderOrderService $orderService)
    {
        $this->providerOrderService = $orderService;
    }

    /**
     * Submit order
     * @throws ClientErrorException
     */
    public function store(SubmitOrderRequest  $request):JsonResponse
    {
        $this->providerOrderService->submitOrder($request->validated());

        return successResponse();
    }
}
