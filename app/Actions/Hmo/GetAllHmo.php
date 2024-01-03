<?php

namespace App\Actions\Hmo;

use App\Models\Hmo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllHmo 
{
    use AsAction;

    public function handle(): JsonResponse
    {
        $hmo = Hmo::all();

        return response()->json(['status' => true, 'message' => 'Hmo(s) retrieved successfully', 'data' => $hmo], 200);
    }

    public function asController(Request $request): JsonResponse
    {
        try {

            return $this->handle();

        } catch (Exception $e) {
        
            Log::error($e);

            return response()->json(['status' => false, 'message' => 'An error occurred while getting all hmos.'], 500);
        }
    }

}