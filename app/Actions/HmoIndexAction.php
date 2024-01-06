<?php

namespace App\Actions;

use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class HmoIndexAction
{
    public function handle()
    {
        return Hmo::select('id', 'code')->get();
    }

    public function asController()
    {
        $hmos = $this->handle();

        return response()->json([
            'status' => true,
            'message' => 'HMOs successfully retrieved',
            'code' => Order::HMO_RETRIEVED,
            'data' => $hmos,
        ], JsonResponse::HTTP_OK);
    }
}
