<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class SubmitOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'provider_name' => ['required', 'string', 'min:3', 'max:50'],
            'hmo_code' => ['required', 'string', 'exists:hmos,code'],
            'encounter_date' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'items' => ['required', 'array', 'max:20'],
            'items.*.item' => ['required', 'string', 'min:3', 'max:50'],
            'items.*.unit_price' => ['required', 'numeric', 'min:1'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
