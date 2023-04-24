<?php

namespace App\Actions\Provider;

use App\Http\Requests\Provider\SubmitOrderRequest;
use App\Mail\Provider\OrderSubmitted;
use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class SubmitOrder
{
    use AsAction;

    public function handle(array $submitOrderData): Order
    {
        $hmo = Hmo::findByCode($submitOrderData['hmo']);

        ['name' => $provider, 'encounter_date' => $encounterDate] = $submitOrderData;

        return $hmo->orders()->create([
            'provider' => $provider,
            'items' => data_get($submitOrderData, 'items'),
            'encounter_date' => $encounterDate,
            'status' => Order::STATUS_PENDING,
        ]);
    }

    public function asController(SubmitOrderRequest $request): JsonResponse
    {
        try {
            $createdOrder = $this->handle($request->validated());
        } catch (\Throwable $th) {
            report($th); //log exception for monitoring.

            return $this->formatJsonResponse(
                'An error occurred while attempting to submit your order.',
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        //send the mail here
        Mail::to($createdOrder->hmo->email)->send(new OrderSubmitted($createdOrder));

        return $this->formatJsonResponse('Order submitted successfully.');
    }

    private function formatJsonResponse(string $message, int $statusCode = JsonResponse::HTTP_OK): JsonResponse
    {
        $status = $statusCode >= 200 && $statusCode < 400;

        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $statusCode);
    }
}
