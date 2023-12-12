<?php

namespace App\Http\Requests;

use App\DTOs\Models\HMOData;
use App\Models\Hmo;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $hmo
 * @property string $encounterDate
 */
class SaveOrderItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'providerName' => ['required', 'string', 'max:70'],
            'hmo' => ['required', 'string', 'exists:hmos,code'],
            'encounterDate' => ['required', 'date'],
            'orderItems' => ['required','array'],
            'orderItems.*.name' => ['required', 'string', 'max:500'],
            'orderItems.*.unit_price' => ['required', 'numeric'],
            'orderItems.*.quantity' => ['required', 'integer']
        ];
    }

    public function messages()
    {
        return [
          'orderItems.*.name.required' => 'The Order Item field is required',
          'orderItems.*.unit_price.required' => 'The Unit Price field is required',
          'orderItems.*.quantity.required' => 'The quantity field is required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}
