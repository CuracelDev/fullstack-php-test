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
    
    }

    public function add($data) {
        
    }
}
