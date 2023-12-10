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
            'provideName' => ['required', 'string', 'max:70'],
            'hmo' => ['required', 'string', 'exists:hmos,code'],
            'encounterDate' => ['required', 'date'],
            'orderItems' => ['required','array'],
            'orderItems.*.name' => ['required', 'string', 'max:500'],
            'orderItems.*.unit_price' => ['required', 'numeric'],
            'orderItems.*.quantity' => ['required', 'integer']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}
