<?php

namespace App\Services;

use App\Models\Hmo;
use Illuminate\Foundation\Http\FormRequest;

class HmoService 
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
 
    public function saveHmoBatchData(FormRequest $request)
    {
        $hmo = $this->retrieveHmo($request);
        return $this->orderService->createHmoOrder($hmo, $request);
    }

    protected function retrieveHmo(FormRequest $request): Hmo
    {
        $hmo = Hmo::where('code', $request->code)->first();
        if (!$hmo) $hmo = $this->createHmo($request);
        return $hmo;
    }

    protected function createHmo(FormRequest $request): Hmo
    {
        return Hmo::create([
            'name' => $request->name,
            'code' => $request->code
        ]);
    }
}

