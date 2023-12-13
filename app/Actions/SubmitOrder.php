<?php

namespace App\Actions;

use App\Events\OrderSubmitted;
use App\Http\Requests\SubmitOrderRequest;
use App\Models\Hmo;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class SubmitOrder 
{
    use AsAction;

    public function handle(string $hmoCode, string $providerName, string $encounterDate, array $items)
    {
        $result = ProcessItems::run($items);

        $hmo = Hmo::firstWhere('code', $hmoCode);

        $order = $hmo->orders()->create([
            'provider_name' => $providerName,
            'items' => $result['items'],
            'order_amount' => $result['total'],
            'encounter_date' => Carbon::parse($encounterDate),
        ]);

        OrderSubmitted::dispatch($order);
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
