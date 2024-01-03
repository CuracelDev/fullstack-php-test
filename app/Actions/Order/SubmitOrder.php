<?php

namespace App\Actions\Order;

use App\Http\Requests\Order\SubmitOrderRequest;
use App\Mail\Order\OrderCreatedMail;
use App\Models\Hmo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class SubmitOrder 
{
    use AsAction;

    public function handle(array $orderData): JsonResponse
    {
        $hmo = Hmo::where('code', $orderData['hmo_code'])->first();

        if(!$hmo){
            return response()->json(['status' => false, 'message' => 'Invalid hmo code'], 400);
        }

        $order = $hmo->orders()->create([
            'provider_name' => $orderData['provider_name'],
            'items' => $orderData['items'],
            'encounter_date' => $orderData['encounter_date']
        ]);

        Mail::to($order->hmo->email)->send(new OrderCreatedMail($order));

        return response()->json(['status' => true, 'message' => 'Order submitted successfully'], 200);
    }

    public function asController(SubmitOrderRequest $request): JsonResponse
    {
        try {

            return $this->handle($request->validated());

        } catch (Exception $e) {
        
            Log::error($e);

            return response()->json(['status' => false, 'message' => 'An error occurred while attempting to submit your order.'], 500);
        }
    }

}