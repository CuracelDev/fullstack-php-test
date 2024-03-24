<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitOrderRequest extends FormRequest
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
            'hmo_code' => ['required', 'string', 'exists:hmos,code'],
            'provider_name' => ['required','string'],
            'encounter_date' => ['required', 'date'],
            'items' => ['required','array'],
            'items.*.item' => ['required','string'],
            'items.*.unit_price' => ['required','numeric'],
            'items.*.quantity' => ['required','numeric'],
        ];
    }


    public function messages(): array
    {
        return[
            'hmo_code.exists' => 'Invalid HMO Code',
            'provider_name.required' => 'Enter your company name',
            'encounter_date.required' => 'Enter encounter date',
            'items.*.item.required' => 'Please enter  name for all items',
            'items.*.unit_price.required' => 'Please enter  unit price for all items',
            'items.*.quantity.required' => 'Please enter  quantity for all items',
            'items.*.unit_price.numeric' => 'Unit price for all items must be numeric',
            'items.*.quantity.numeric' => 'Quantity for all items must be numeric'
        ];
    }
}
