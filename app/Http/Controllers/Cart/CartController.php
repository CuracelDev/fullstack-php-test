<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Coupon\CouponController;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::get();

        return CartResource::collection($cart);
    }

    public function addCartItems(CartRequest $request)
    {
        $user_id = Auth()->user()->id;

        $cart = Cart::firstorCreate(['user_id' => $user_id]);

        $coupon = Coupon::where('user_id', $user_id)->where('product_id', $request->product_id)
            ->where('active', 1)->exists();
        
        if ($coupon) {
            
            $check = Coupon::where('code', '=', $request->coupon_code)->exists();

            if(!$check){
                return response(['message' => 'Coupon not correct'], Response::HTTP_BAD_REQUEST);
            };

            $getDiscount = Coupon::where('code', '=', $request->coupon_code)->first();

            $getPercent = $getDiscount->discount_percent/100 * $request->product_price;
            
            $getDiscountedPrice = $request->product_price - $getPercent;

            $item = CartItems::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'product_price' => $request->product_price,
                'product_name' => $request->product_name,
                'coupon_code' => $request->coupon_code,
                'total_amount' => (int) $request->quantity * $getDiscountedPrice,
            ]);

            return response($item, Response::HTTP_OK);
        };
        
        $item = CartItems::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'product_price' => $request->product_price,
            'product_name' => $request->product_name,
            'coupon_code' => $request->coupon_code,
            'total_amount' => (int) $request->quantity * $request->product_price,
        ]);

        return response($item, Response::HTTP_CREATED);
    }
}
