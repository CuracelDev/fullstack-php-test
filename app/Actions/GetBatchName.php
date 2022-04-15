<?php

namespace App\Actions;

use App\Models\Hmo;
use Carbon\Carbon;

class GetBatchName
{
    public function handle(Hmo $hmo, $encounterDate, $provider)
    {
        $carbonInstance = $hmo->batch_by === Hmo::BATCH_BY_MONTH ? Carbon::parse($encounterDate)
        : Carbon::now();

        return "$provider $carbonInstance->monthName $carbonInstance->year";
    }
}
