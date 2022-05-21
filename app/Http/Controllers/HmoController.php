<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\HmoService;

class HmoController extends Controller
{

    private $hmoService;

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

    public function batchOrder($id)
    {
        $hmo = $this->hmoService->get($id);
        if(!$hmo){
            return response()->json(['message'=>'HMO not found'],404);
        }

        return $this->hmoService->batchOrder($hmo->batch_type,$id);

    }
}
