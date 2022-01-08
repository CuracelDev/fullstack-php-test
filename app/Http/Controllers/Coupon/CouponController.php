<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    // get all coupons with all thier relationships
    public function index()
    {
        $coupon = Coupon::with('product','user')->get();

        return response($coupon, Response::HTTP_OK);
    }

    // store a new coupon
    public function store(CouponRequest $request)
    {
        // generate a unique incrementing coupon code for each user
        if (!(Coupon::where('code', 'COP-001001')->first())) {
            $coupon_code = 'COP-001001';
        } else {
            $number = Coupon::get()->last()->code;
            $number = str_replace('COP-', "", $number);
            $number = str_pad($number + 1, 7, '0', STR_PAD_LEFT);
            $coupon_code = 'COP-' . $number;
        }

        $coupon = Coupon::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'code' => $coupon_code,
            'discount_percent' => $request->discount_percent,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'active' => 1
        ]);

        return response($coupon, Response::HTTP_CREATED);
    }
}
