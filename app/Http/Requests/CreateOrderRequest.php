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
            'orderItems.*.qty' => 'bail|required|integer|min:1',
            'orderItems.*.uPrice' => 'bail|required|numeric|min:0.00',
            'orderItems.*.subTotal' => 'bail|required|numeric|min:0.00',
        ];
    }

    /**
     * Check if the total price is not tempered with
     *
     * @param \Illuminate\Validation\Validator $validator 
     * 
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(
            function ($validator) {
                if (!$this->isTotalPriceValid()) {
                    $validator->errors()->add(
                        'totalPrice',
                        'The total price is invalid'
                    );
                }
            }
        );
    }

    /**
     * Get the subTotal from the request and add it up and use it to check the total
     * 
     * @return boolean
     */
    protected function isTotalPriceValid()
    {
        $totalPrice = collect(
            $this->input('orderItems')
        )->sum(
            function ($item) {
                return $item['subTotal'];
            }
        );
        return $totalPrice == $this->input('totalPrice');
    }
}
