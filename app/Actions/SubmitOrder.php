<?php

namespace App\Actions;

use App\Http\Requests\SubmitOrderRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class SubmitOrder 
{
    use AsAction;

    public function handle(string $code, string $providerName, string $date, array $items)
    {
       
    }

    public function asController(SubmitOrderRequest $request)
    {
        $this->handle(
            $request->hmo_code,
            $request->provider_name,
            $request->encounter_date,
            $request->items
        );

        return response()->json(['success' => true, 'message' => 'Order processed']);
    }
}
