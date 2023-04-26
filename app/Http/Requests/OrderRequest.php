<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'hmo_code' => ['required', 'exists:hmos,code'],
            'provider_code' => ['required', 'exists:providers,code'],
            'items' => ['required', 'array'],
            'items.*.name' => ['required', 'string'],
            'items.*.quantity' => ['required', 'numeric'],
            'items.*.unit_price' => ['required', 'numeric'],
            'encounter_date' => ['required', 'date'],
            'sent_date' => ['required', 'date'],
        ];
    }
}
