<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItems;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::get();

        // return response($cart, Response::HTTP_OK);
        return CartResource::collection($cart);
    }

    public function addCartItems(CartRequest $request)
    {
        $user_id = Auth()->user()->id;

        $cart = Cart::firstorCreate(['user_id' => $user_id]);

        $item = CartItems::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'product_price' => $request->product_price,
            'product_name' => $request->product_name,
            'total_amount' => (int) $request->quantity * (int) $request->product_price,
        ]);

        return response($item, Response::HTTP_OK);
    }
}
