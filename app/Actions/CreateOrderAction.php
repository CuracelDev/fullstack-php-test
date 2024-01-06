<?php

namespace App\Actions;

use App\Http\Requests\CreateOrderRequest;
use App\Mail\OrderCreatedNotification;
use App\Models\Hmo;
use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrderAction
{
    use AsAction;

    public function handle(array $orderPayload): Order
    {
        try {
            $hmo = Hmo::where('code', $orderPayload['hmo_code'])
                ->select('id', 'code', 'email', 'name')
                ->first();

            if (!$hmo) {
                logger('HMO not found: ' . $orderPayload['hmo_code']);

                throw new Exception('HMO not found');
            }

            logger()->info('Creating order for HMO: ' . $hmo->code);

            return $hmo->orders()->create([
                'provider' => $orderPayload['provider_name'],
                'encounter_date' => $orderPayload['encounter_date'],
                'items' => $orderPayload['items'],
                'status' => Order::PENDING_STATUS,
            ]);
        } catch (Exception $e) {
            logger('Error creating order: ' . $e->getMessage());

            throw new Exception('Error creating order');
        }
    }

    public function asController(CreateOrderRequest $request)
    {
        $order = $this->handle($request->validated());

        Mail::to($order->hmo->email)
            ->send(new OrderCreatedNotification($order));

        return response()->json([
            'status' => true,
            'message' => 'Order successfully saved',
            'code' => Order::CREATED_STATUS,
            'data' => $order,
        ], JsonResponse::HTTP_CREATED);
    }
}
