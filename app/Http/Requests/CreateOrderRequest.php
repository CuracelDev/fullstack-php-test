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
     * The error massage that will be displayed 
     * 
     * @return array
     */
    // public function messages()
    // {
    //     [
    //         'hmoCode.exists' => 'This Code is not Valid',
    //         'hmoCode.required' => 'The code for HMO is needed',
    //         'orderItems.required' => 'Please submit some orders',
    //         'totalPrice.required' => "How come you don't have a total",
    //         'encounterDate.required' => 'Please choose a Date',
    //         'encounterDate.date' => 'Please choose a true Date',
    //         'orderItems.*.item.required' => 'Please give an item name',
    //         'orderItems.*.item.required' => 'Please give an item name',
    //         'orderItems.*.qty.required' => 'Please give a quantity',
    //         'orderItems.*.qty.integer' => 'Please give a quantity that is number',
    //         'orderItems.*.qty.min' => 'Please give a quantity that is aleast 1',
    //         'orderItems.*.uPrice.required' => 'Please give a quantity that is number',
    //         'orderItems.*.uPrice.numeric' => 'Please give a unit price that is number',
    //         'orderItems.*.uPrice.min' => 'Please give a unit price that is aleast 1',
    //         'orderItems.*.subTotal.numeric' => 'Please give a unit price that is number',
    //         'orderItems.*.subTotal.min' => 'Please give a unit price that is aleast 1',
    //     ];
    // }

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
                        'totalPrice', 'The total price is invalid'
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
