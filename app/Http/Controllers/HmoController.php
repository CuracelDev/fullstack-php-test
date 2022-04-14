<?php

namespace App\Http\Controllers;

use App\Http\Resources\HmoResource;
use App\Models\Hmo;
use Illuminate\Http\Request;

class HmoController extends Controller
{
    public function index()
    {
        return $this->success(HmoResource::collection(Hmo::all()));
    }
}
