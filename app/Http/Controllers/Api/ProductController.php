<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductShowResource;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return ProductIndexResource::collection(Product::all());
    }

    public function show($id)
    {
        return new ProductShowResource(Product::findOrFail($id));
    }

    public function price(Request $request, $id)
    {
        $data = $request->validate([
            'coupon' => 'required|string',
        ]);

        $coupon = Coupon::with('user')->where('product_id', $id)->first();

        //dd($coupon);

        return $request->coupon === $coupon->code
        ? response()->json([], 200)
        : response()->json([
            "message" => "Coupon Code is Invalid!"
        ], 400);
    }
}
