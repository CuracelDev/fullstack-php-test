<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(5);

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        
        $order = Order::firstOrCreate($this->dataToStore($request->validated()));

        return $order;
    }

    /**
     * This get the validated data and match it to the db 
     * 
     * @param $data 
     * 
     * @return array
     */
    public function dataToStore($data)
    {
        $hmo = Hmo::where('code', $data['hmoCode'])->first();
        $provider = Provider::where('name', $data['provider'])->first();
        return [
            'items' => $data['orderItems'],
            'hmo_id' => $hmo->id,
            'provider_id' => $provider->id,
            'encounter_date' => $data['encounterDate']
        ];
    }
}
