<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\HmoService;

class HmoController extends Controller
{

    public function __construct(HmoService $hmoService){
        $this->$hmoService = $hmoService;
    }
    

    public function create(Request $request)
    {
        $v = Validator::make($request->all(),[
            'code'=>'required|unique:hmos,code',
            'name'=> 'required|string',
        ]);

        if($v->fails()){
            return response()->json(['message'=>$v->messages()],422);
        }

        $hmo = $this->$hmoService->create($request->all());

        return response()->json($hmo);

    }
}
