<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Coupon as CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        return CouponResource::collection(Coupon::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'discount' => 'required',
            'user_id' => 'required',
            'product_id' => 'required',
        ]);

        $code = $request->code;
        $discount = $request->discount;
        $user_id = $request->user_id;
        $product_id = $request->get('product_id');

        $data = [];

        foreach ($product_id as $key => $p_id) {
            $data[] = [
                'code' => $code . '-' . $key,
                'discount' => $discount,
                'user_id' => $user_id,
                'product_id' => $p_id,
            ];
        }

        Coupon::insert($data);

    }
}
