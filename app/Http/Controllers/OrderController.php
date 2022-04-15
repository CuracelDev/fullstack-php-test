<?php

namespace App\Http\Controllers;

use App\Actions\GetBatchName;
use App\Events\OrderStored;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Hmo;
use App\Models\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function store(OrderStoreRequest $request)
    {
        $hmo = $request->hmo();

        $order = Order::create([
            'provider' => $request->get('provider'),
            'items' => $request->get('orders'),
            'total' => $request->get('total'),
            'encounter_date' => $request->get('encounter_date'),
            'hmo_id' => $hmo->id,
            'batch' => app()->make(GetBatchName::class)->handle($hmo, $request->get('encounter_date'), $request->get('provider'))
        ]);

        OrderStored::dispatch($order);

        return $this->success(new OrderResource($order), '', 201);
    }
}
