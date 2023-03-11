<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'provider_code' => 'required|exists:providers,code',
            'hmo_code' => 'required|exists:hmos,code',
            'batch_id' => 'nullable|exists:batches,id',
            'items' => 'required|array',
            'encounter_date' => 'required|date',
            'sent_date' => 'required|date',
        ];
    }
}
