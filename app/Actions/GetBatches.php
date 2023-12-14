<?php

namespace App\Actions;

use App\Models\Hmo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class GetBatches extends BaseAction
{
    public function handle($hmo): Collection
    {
        return $hmo->batches;
    }

    public function asController(Hmo $hmo)
    {
        $hmos = $this->handle($hmo);

        return response()->json(['data' => $hmos, 'success' => true, 'message' => 'Hmo Batches Retrived']);
    }
}
