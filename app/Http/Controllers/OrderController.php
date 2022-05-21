<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->all();
        return response()->json($orders);
    }

    public function create(Request $request)
    {
        $v = Validator::make($request->all(),[
            'provider_id'=>'bail|required|exists:users,id',
            'hmo_id'=> 'bail|required|exists:hmos,id',
            'items.*.name'=>'bail|required|string',
            'items.*.unitPrice'=>'bail|required|numeric|min:1',
            'items.*.qty'=>'bail|required|numeric|min:1',
            'items.*.subTotal'=>'bail|required|numeric|min:1',
            'encounter_date'=>'bail|required|date',
            'total'=>'bail|required|numeric|min:1'
        ]);

        if($v->fails()){
            return response()->json(['message'=>$v->messages()->first()],422);
        }

        $items = json_encode($request->items);

        $data = array_merge($request->except('items'),['items'=>$items]);
        
        $order = $this->orderService->create($data);

        return response()->json($order);
    }

    public  function createOrder(Request $request)
    {
        $hmos = \App\Models\Hmo::all();
        return view('create-order',['hmos'=>$hmos]);
    }
}
