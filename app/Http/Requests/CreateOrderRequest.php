<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider_name' => ['string', 'required', 'max:255', 'min:3'],
            'hmo_code' => ['string', 'required', 'exists:hmos,code'],
            'encounter_date' => ['date', 'required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'items' => ['array', 'required'],
            'items.*.item' => ['required', 'string', 'min:2', 'max:50', 'distinct:ignore_case'],
            'items.*.price' => ['required', 'numeric', 'gt:0'],
            'items.*.quantity' => ['required', 'integer', 'gt:0'],
        ];
    }

    /**
     * Get the custom attribute names for the validator.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'provider_name' => 'Provider Name',
            'hmo_code' => 'HMO Code',
            'encounter_date' => 'Encounter Date',
            'items' => 'Items',
            'items.*.item' => 'Item',
            'items.*.price' => 'Price',
            'items.*.quantity' => 'Quantity',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'items.min' => 'You must add at least 1 item',
            'items.max' => 'You can only add up to 30 items at a time',
            'items.*.item.distinct' => 'There is a duplicate item in the list. Please remove it.',
        ];
    }
}
