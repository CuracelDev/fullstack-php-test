<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Repositories\CouponRepository;

class CouponController extends Controller
{
    protected $coupon;

    public function __construct(
        CouponRepository $coupon
    ) {
        $this->coupon = $coupon;
    }

    public function coupons() {
        
    }

    public function add(Request $request) {
 
    }
}
