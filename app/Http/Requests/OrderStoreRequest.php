<?php

namespace App\Http\Requests;

use App\Models\Hmo;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'provider' => ['string', 'required'],
            'hmo_code' => ['string', 'required', 'exists:App\Models\Hmo,code'],
            'orders' => ['array', 'required', 'min:1'],
            'orders.*.item' => ['string', 'required'],
            'orders.*.unit' => ['numeric', 'required'],
            'orders.*.subtotal' => ['numeric', 'required'],
            'total' => ['numeric', 'required'],
            'encounter_date' => ['required', 'date', 'date_format:Y-m-d']
        ];
    }

    public function hmo()
    {
        return Hmo::byCode($this->hmo_code)->first();
    }
}
