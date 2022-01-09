<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Coupon\CouponController;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Coupon;
use App\Models\UserBuyCount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Get the cart that belongs to the logged in user,
    // we are returning the data with the use of Laravel Resource
    // check the cart model to see how I am calculating the tax
    public function index()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->get();

        return CartResource::collection($cart);
    }

    // The function that lets users add item to cart,
    // This function is being validated with the use laravel request, in the request folder 
    public function addCartItems(CartRequest $request)
    {
        $user_id = Auth()->user()->id;

        // first or create is used because it will check if the item has been created or not
        // if it has not been created, it will create a new one, if it has been created,
        // it will simply continue to add items to the cart
        $cart = Cart::firstorCreate(['user_id' => $user_id]);

        // incase a user has an active coupon and wants to use it, we set up a check
        $coupon = Coupon::where('user_id', $user_id)->where('product_id', $request->product_id)
            ->where('active', 1)->exists();
        
        // so it is true the user has a coupon, now, lets check if the coupon inputted is correct
        $check = Coupon::where('code', $request->coupon_code)->first();
        
        // if coupon exists(true) and the coupon code field is not null, then, this will run
        if ($coupon && $request->coupon_code != null) {
            
            // if it is not correct, then we return a bad request error
            if(!$check && $request->coupon_code != null){
                return response(['message' => 'Coupon not correct'], Response::HTTP_BAD_REQUEST);
            };

            // if the coupon code is correct then we get the coupon row belonging to the user
            $getDiscount = Coupon::where('code', '=', $request->coupon_code)->first();

            // get the discount percentage and divide by 100 then multiply by product price
            $getPercent = $getDiscount->discount_percent/100 * $request->product_price;
            
            // deduct the result of the calculation above from the product price to get the discounted price
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

            // after entering a valid coupon code, then the coupon code for that product should be deleted 
            $getDiscount->delete();

            return response($item, Response::HTTP_OK);
        };

        // if user doesn't have a coupon and the coupon field is null, then, run this instead
        $item = CartItems::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'product_price' => $request->product_price,
            'product_name' => $request->product_name,
            'coupon_code' => $request->coupon_code,
            'total_amount' => (int) $request->quantity * $request->product_price,
        ]);

        return response($item, Response::HTTP_OK);
    }
}
