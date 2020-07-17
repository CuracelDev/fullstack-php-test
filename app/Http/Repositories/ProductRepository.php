<?php

namespace App\Http\Repositories;
use App\Http\CommonHelper;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use DB;
use Validator;

class ProductRepository
{
    use CommonHelper;
    
    protected $product;

    public function __construct(
        Product $product
    ) {
        $this->product = $product;
    }

    public function getProduct($productId) {
        return new ProductResource($this->product->with('orders')->find($productId));
    }

    public function products() {
        $products = ProductResource::collection($this->product->orderBy('id', 'DESC')->get());
        return $products;
    }

    public function add($data) {
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'age_limit_status' => 'required',
            'coupon_status' => 'required',
            'frequency_limit_status' => 'required'
        ];

        $validator = Validator::make($data->all(), $rules);
        $errors = $validator->errors();
        
        if($validator->fails()) {
            foreach($errors->all() as $error) {
                $error_details = ['type' => 'error', 'message' => $error];
                return $error_details;
            }
        } else {
            $product_exists = $this->product->whereName($data->name)->first();
            
            if($product_exists) {
                $details = ['type' => 'error','message' => 'Product has been added before. Try again.'];
                return $details;
            } else {

                $start_age_range = ($data->age_limit_status == 'yes') ? $data->start_age_range : '';
                $end_age_range = ($data->age_limit_status == 'yes') ? $data->end_age_range : '';
                $coupon_id = ($data->coupon_status == 'yes') ? $data->coupon_id : '';
                $frequency_limit = ($data->frequency_limit_status == 'yes') ? $data->frequency_limit : '';
                
                $product = $this->product->create([
                    'name' => $data->name,
                    'price' => $data->price,
                    'age_limit_status' => $data->age_limit_status,
                    'start_age_range' => $start_age_range,
                    'end_age_range' => $end_age_range,
                    'coupon_status' => $data->coupon_status,
                    'coupon_id' => $coupon_id,
                    'frequency_limit_status' => $data->frequency_limit_status,
                    'frequency_limit' => $frequency_limit,
                ]);

                $details = [
                    'type' => 'success',
                    'product' => $product,
                ];

                return $details;
            }
        }
    }
}
