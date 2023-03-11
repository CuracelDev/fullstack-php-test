<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrder;
use App\Enums\HmoBatchCriteria;
use App\Http\Requests\CreateOrderRequest;
use App\Mail\NewOrderNotification;
use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use App\Services\Batches\EncounterDateBatch;
use App\Services\Batches\SentDateBatch;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(CreateOrderRequest $payload)
    {
        $provider = Provider::where('code', $payload['provider_code'])->first();
        $hmo = Hmo::where('code', $payload['hmo_code'])->first();

        $payload = $payload->validated();
        $payload['provider_id'] = $provider->id;
        $payload['hmo_id'] = $hmo->id;
        $order = Order::create($payload);

        //Create the batch for the order 😇
        $batch = match ($order->hmo->batch_by) {
            HmoBatchCriteria::SUBMIT_DATE->value => new SentDateBatch(),
            default => new EncounterDateBatch(),
        };
        $batch->create($order);

        Mail::to($order->hmo->email)->queue(new NewOrderNotification($order));

        return response()->json(['message' => 'Order submitted successfully']);
    }
}
