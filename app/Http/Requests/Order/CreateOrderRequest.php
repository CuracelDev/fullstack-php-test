<?php

namespace App\Http\Requests\Order;

use App\Models\Hmo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'provider' => ['string', 'required', 'max:60', 'min:3'],
            'hmo_id' => ['required', 'integer', Rule::exists(Hmo::class, 'id')],
            'encounter_date' => [
                'date', 'required',
                'date_format:Y-m-d', 'before_or_equal:' . now()->format('Y-m-d')
            ],
            'items' => ['array', 'required'],
            'items.*.item' => ['required', 'string', 'min:2', 'distinct:ignore_case'],
            'items.*.price' => ['required', 'numeric', 'gt:0'],
            'items.*.quantity' => ['required', 'integer', 'gt:0'],
        ];
    }

    public function attributes(): array
    {
        return [
            'provider' => 'Provider name',
            'hmo_id' => 'HMO code',
            'encounter_date' => 'Encounter date',
            'items' => 'Items',
            'items.*.item' => 'Item',
            'items.*.price' => 'Price',
            'items.*.quantity' => 'Quantity',
        ];
    }

    public function messages(): array
    {
        return [
            'items.min' => 'You must add at least 1 item',
            'items.*.item.distinct' => 'There is a duplicate item in the list. Please remove it.',
        ];
    }
}
