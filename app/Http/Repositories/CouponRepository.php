<?php

namespace App\Http\Repositories;
use App\Http\CommonHelper;
use App\Models\Coupon;
use DB;
use Validator;

class CouponRepository
{
    use CommonHelper;
    
    protected $coupon;

    public function __construct(
        Coupon $coupon
    ) {
        $this->coupon = $coupon;
    }

    public function coupons() {
        $coupons = $this->coupon->orderBy('id', 'DESC')->get();
        return $coupons;
    }

    public function add($data) {
        $rules = [
            'code' => 'required',
            'tax' => 'required',
        ];

        $validator = Validator::make($data->all(), $rules);
        $errors = $validator->errors();
        
        if($validator->fails()) {
            foreach($errors->all() as $error) {
                $error_details = ['type' => 'error', 'message' => $error];
                return $error_details;
            }
        } else {
            $coupon_exists = $this->coupon->whereCode($data->code)->first();
            
            if($coupon_exists) {
                $details = ['type' => 'error','message' => 'Coupon code exists. Try again.'];
                return $details;
            } else {

                $coupon = $this->coupon->create([
                    'code' => strtoupper($data->code),
                    'tax' => $data->tax,
                ]);

                $details = [
                    'type' => 'success',
                    'coupon' => $coupon,
                ];

                return $details;
            }
        }
    }
}
