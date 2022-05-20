<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ProviderService;
class ProviderController extends Controller
{
    public function __construct(ProviderService $provider)
    {
        $this->provider = $provider;
    }
    
    public function create(Request $request)
    {
        $v = Validator::make($request->all(),[
            'name'=>'required',
        ]);

        if($v->fails()){
            return response()->json(['message'=>$v->messages()],422);
        }

        $provider = $this->provider->create($request->all());

        return response()->json($provider);
    }
}
