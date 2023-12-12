<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class GetTotalPriceAction
{
    use AsAction;

    public function handle($itemData)
    {
        $total = 0;

        foreach ($itemData as $_itemData) {
            $total += $_itemData->quantity * $_itemData->unit_price;
        }

        return $total;
    }
}
