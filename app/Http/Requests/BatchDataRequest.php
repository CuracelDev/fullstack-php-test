<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchDataRequest extends FormRequest
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
            'code' => 'required|string',
            'name' => 'required|string',
            'encounter_date' => 'required|date',
            'items' => 'array',
            'items.*.title' => 'required|string',
            'items.*.unit_price' => 'required',
            'items.*.quantity' => 'required|numeric',
        ];
    }
}
