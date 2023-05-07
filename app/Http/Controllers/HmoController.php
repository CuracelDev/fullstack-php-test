<?php

namespace App\Http\Controllers;

use App\Http\Requests\BatchDataRequest;
use App\Models\Hmo;
use App\Services\HmoService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HmoController extends Controller
{
    protected HmoService $hmoService;
    protected OrderService $orderService;

    public function __construct(HmoService $hmoService, OrderService $orderService)
    {
        $this->hmoService = $hmoService;
        $this->orderService = $orderService;
    }

    public function batchData(BatchDataRequest $request)
    {
        Log::info(sprintf("Request Data : %s", $request));
        $response = $this->hmoService->saveHmoBatchData($request);
        return response()->json($response->toArray(), 200);
    }

    public function retrieveBatchData()
    {
        $response = $this->orderService->batchHmoOrders();
        return response()->json($response->toArray(), 200);
    }
}
