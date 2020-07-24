<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $data = $request->validate([
            'coupon' => 'required|string',
        ]);

        $coupon = Coupon::with('user')->where('product_id', $id)->first();
        $product = Product::findOrFail($id);

        // check coupon is valid
        if ($request->coupon !== $coupon->code) {
            return response()->json([
                "message" => "Coupon Code is Invalid!",
            ], 400);
        }

        // check age limit
        if ($coupon->user->age < $product->age_limit) {
            return response()->json([
                "message" => "User is below age limit for this product!",
            ], 400);
        }

        // calculate discounted price
        $initial_price = $product->price;
        $discounted_price = $initial_price - ($initial_price * $coupon->discount) / 100;

        // calculate tax
        if ($coupon->user->tax) {
            $tax = ($discounted_price * $coupon->user->tax) / 100;
            $tax = $tax - ($tax * $coupon->discount) / 100;

            $total_price = $discounted_price + $tax;
        } else {
            $tax = 0;
            $total_price = $discounted_price;
        }

        return response()->json([
            "initial_price" => $initial_price,
            "discounted_price" => $discounted_price,
            "tax" => $tax,
            "total_price" => $total_price,
        ], 200);

    }
}
