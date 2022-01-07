<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    public function index()
    {
        $coupon = Coupon::get();

        return response($coupon, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        if (!(Coupon::where('coupon_code', 'COP-0001001')->first())) {
            $coupon_code = 'COP-0001001';
        } else {
            $number = Coupon::get()->last()->coupon_code;
            $number = str_replace('EVT-', "", $number);
            $number = str_pad($number + 1, 7, '0', STR_PAD_LEFT);
            $coupon_code = 'EVT-' . $number;
        }

        $coupon = Coupon::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'code' => $coupon_code,
            'discount_percent' => $request->discount_percent,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at
        ]);

        return response($coupon, Response::HTTP_CREATED);
    }
}
