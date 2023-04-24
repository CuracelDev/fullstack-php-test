<?php

namespace App\Http\Requests\Provider;

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
            'name' => ['required', 'string', 'min:2', 'max:20'],
            'hmo' => ['required', 'string', 'exists:hmos,code'],
            'encounter_date' => ['required', 'date', 'before_or_equal:today'],
            'items' => ['required', 'array'],
            'items.*' => ['required', 'array'],
            'items.*.item' => ['required', 'string', 'min:2', 'max:50', 'distinct:ignore_case'],
            'items.*.price' => ['required', 'numeric', 'gt:0'],
            'items.*.quantity' => ['required', 'integer', 'gt:0'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'items.*.item' => 'item',
            'items.*.price' => 'price',
            'items.*.quantity' => 'quantity',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'items.*.item.distinct' => 'One of the items has been entered twice. You can fix this by removing the duplicate item',
        ];
    }
}
