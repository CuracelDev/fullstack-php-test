<?php

namespace App\Actions;

use App\Events\OrderCreated;
use App\Models\Hmo;
use App\Models\Order;
use App\Traits\HasResponse;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Facades\Actions;
use App\Notifications\OrderCreated as OrderCreatedNotification;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class BatchOrder extends Actions {
    use AsAction, HasResponse;

    public function asController(ActionRequest $request) : JsonResponse
    {
        return $this->handle(
            $request->validated()
        );
    }

    public function handle(array $requestData) : JsonResponse
    {
        $requestData['batch'] = $this->getBatch(
            $requestData['provider_name'], 
            $requestData['hmo_code'], 
            $requestData['encounter_date']
        );

        $order = Order::create($requestData);

        //Send email to Hmo
        OrderCreated::dispatch($order);

        return $this->successResponse('Order was created successfully', $order);
    }

    /**
     * Return the batch formatted according to Hmo needs
     */
    protected function getBatch(string $providerName, string $hmoCode, string $ecounterDate) : string
    {
        $hmo = Hmo::where('code', $hmoCode)->firstOrFail();
        $date = $hmo->batch_criteria === Hmo::BATCH_CRITERIA_ENCOUNTER ? 
        $ecounterDate : now();
        
        //format as as Month Year
        $date = date('M Y', strtotime($date));

        return $providerName .' '. $date;
    }

    public function asListener(OrderCreated $event): void
    {
        $event->hmo->notify(new OrderCreatedNotification($event->order));
    }

    public function rules() : array
    {
        return [
            'hmo_code' => ['required', 'string', 'exists:hmos,code'],
            'provider_name' => ['required', 'string', 'max:199'],
            'encounter_date' => ['required', 'date'],
            'items' => ['required','array'],
            'items.*.name' => ['required', 'string', 'max:500'],
            'items.*.unit_price' => ['required', 'numeric'],
            'items.*.quantity' => ['required', 'integer']
        ];
    }

    public function getValidationFailure(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException(
            $validator, 
            new JsonResponse($validator->errors(), 422)
        );
    }
}