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

    public function create(Request $request)
    {
        $v = Validator::make($request->all(),[
            'provider_id'=>'required|exists:users,id',
            'hmo_id'=> 'required|exists:hmos,id',
            'items'=>'required'
        ]);

        if($v->fails()){
            return response()->json(['message'=>$v->messages()],422);
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
