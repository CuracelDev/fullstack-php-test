<?php

namespace App\Http\Controllers;

use App\Http\Resources\HmoApiResource;
use App\Models\Hmo;
use Illuminate\Http\Request;

class HmoController extends Controller
{
    /**
     * Retrieve all Hmo models from the database and return a JSON response containing the collection of resources.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        $hmos = Hmo::all();
        $resources = HmoApiResource::collection($hmos);

        return response()->json($resources, 200, []);
    }
}
