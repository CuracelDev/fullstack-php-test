<?php

namespace App\Actions;

use App\Models\Hmo;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllHmoAction
{
    use AsAction;

    public function handle()
    {
        logger()->info('Retrieving all HMOs');

        return Hmo::select('id', 'code')->get();
    }

    public function asController()
    {
        $hmos = $this->handle();

        return response()->json([
            'status' => true,
            'message' => 'HMOs successfully retrieved',
            'code' => Hmo::HMO_RETRIEVED,
            'data' => $hmos,
        ], JsonResponse::HTTP_OK);
    }
}
