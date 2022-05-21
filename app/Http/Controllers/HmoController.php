<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\HmoService;
use App\Notifications\HmoNotification;

class HmoController extends Controller
{

    private $hmoService;

    public function __construct(HmoService $hmoService){
        $this->hmoService = $hmoService;
    }
    
    public function index()
    {
        $hmos = $this->hmoService->all();
        return response()->json($hmos);
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

        $hmo = $this->hmoService->create($request->all());

        return response()->json($hmo);
    }

    public function orderByBatchType()
    {

    }

    public function batchOrderPage($id)
    {
        $hmo = $this->hmoService->get($id);
        if(!$hmo){
            return view('404');
        }
        return view('batch-order',['id'=>$id,'batch_type'=>$hmo->batch_type]);
    }

    public function batchOrder($id)
    {
        $hmo = $this->hmoService->get($id);
        if(!$hmo){
            return response()->json(['message'=>'HMO not found'],404);
        }

        $batches = $this->hmoService->batch($hmo->batch_type,$id);
        return response()->json($batches);
    }

    public function sendNotification($id)
    {
        $hmo = $this->hmoService->get($id);
        if(!$hmo){
            return response()->json(['message'=>'HMO not found'],404);
        }

        $batches = $this->hmoService->batch($hmo->batch_type,$id);

        $hmo->notify(new HmoNotification($batches));
    }
}
