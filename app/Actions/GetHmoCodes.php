<?php

namespace App\Actions;

use App\Models\Hmo;

class GetHmoCodes extends BaseAction
{
    public function handle(): array
    {
        return Hmo::get()->pluck('code')->toArray();
    }

    public function asController()
    {
        $hmos = $this->handle();

        return response()->json(['data' => $hmos, 'success' => true, 'message' => 'Hmos Code Retrived']);
    }
}
