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
            'name' => ['required', 'string'],
            'hmo' => ['required', 'string', 'exists:hmos,code'],
            'encounter_date' => ['required', 'date', 'before_or_equal:today'],
            'items' => ['required', 'array'],
            'items.*' => ['required', 'array'],
            'items.*.item' => ['required', 'string', 'distinct:ignore_case'],
            'items.*.price' => ['required', 'numeric', 'gt:0'],
            'items.*.quantity' => ['required', 'integer', 'gt:0'],
        ];
    }
}
