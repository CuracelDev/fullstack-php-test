<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    

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

        //creare order


    }
}
