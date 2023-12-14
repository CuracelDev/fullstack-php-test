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
            'hmo_code' => 'required|string|exists:hmos,code',
            'provider_name' => 'required|string',
            'encounter_date' => 'required|date',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.unit_price' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
