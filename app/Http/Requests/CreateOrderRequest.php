<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'hmoCode' => 'bail|required|exists:hmos,code',
            'provider' => 'bail|required|exists:providers,name',
            'orderItems' => 'bail|required|array',
            'totalPrice' => 'bail|required|numeric',
            'encounterDate' => 'bail|required|date',
            'orderItems.*.item' => 'bail|required|string|max:255',
            'orderItems.*.quantity' => 'bail|required|integer|min:1',
            'orderItems.*.unitPrice' => 'bail|required|numeric|min:0.00',
            'orderItems.*.totalPrice' => 'bail|required|numeric|min:0.00',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (! $this->isTotalPriceValid()) {
                $validator->errors()->add('totalPrice', 'The total price is invalid');
            }
        });
    }

    protected function isTotalPriceValid()
    {
        // Get the total price of the order items
        $totalPrice = collect($this->input('orderItems'))->sum(function ($item) {
            return $item['totalPrice'];
        });

        return $totalPrice == $this->input('totalPrice');
    }
}
