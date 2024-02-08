<?php

namespace App\Actions\Orders;

use App\Models\Constants\HmoBatchType;
use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response;

class CreateOrder
{
    use AsAction;

    public function rules(): array
    {
        return [
            'hmo' => ['required', 'string', Rule::exists(Hmo::class, 'code')],
            'provider' => 'required|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|gt:0',
            'items.*.qty' => 'required|integer|min:1',
            'encountered_at' => 'required|date|before_or_equal:now',
        ];
    }

    public function getValidationAttributes(): array
    {
        return [
            'hmo' => 'hmo\'s code',
            'items.*.name' => 'name',
            'items.*.price' => 'price',
            'items.*.qty' => 'quantity',
            'encountered_at' => 'encounter date',
        ];
    }

    public function asController(Request $request): JsonResponse
    {
        $order = $this->handle(
            Hmo::firstWhere('code', $request->input('hmo')),
            $request->all()
        );

        SendOrderMail::dispatchAfterResponse($order);

        return response()->json(['message' => 'Order Created'], Response::HTTP_CREATED);
    }

    public function handle(Hmo $hmo, array $payload): Order
    {
        $date = $hmo->batch_type === HmoBatchType::CREATION_MONTH
            ? now()
            : Date::parse($payload['encountered_at']);

        return $hmo->orders()->create([
            'batch_id' => CreateBatchID::run($payload['provider'], $date),
            'items' => $payload['items'],
            'encountered_at' => $payload['encountered_at'],
        ]);
    }
}
