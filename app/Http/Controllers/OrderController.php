<?php

namespace App\Http\Controllers;

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
            'batch' => $this->getBatchName($hmo, $request->get('encounter_date'), $request->get('provider'))
        ]);

        OrderStored::dispatch($order);

        return $this->success( new OrderResource($order), '', 201);
    }

    private function getBatchName(Hmo $hmo, string $encounterDate, $provider)
    {
        $carbonInstance = $hmo->batch_by === Hmo::BATCH_BY_MONTH ? Carbon::parse($encounterDate)
            : Carbon::now();

        return "$provider $carbonInstance->monthName $carbonInstance->year";
    }
}
