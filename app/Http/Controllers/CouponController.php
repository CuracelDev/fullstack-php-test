<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponProduct;
use App\Models\Product;
use App\Models\User;
use App\Traits\ManagesResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    use ManagesResponse;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $coupons = Coupon::with(['user', 'products'])->get();
        return $this->sendResponse('coupons fetched', $coupons)->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user = User::where('email', $request->user_email)->first();
        if (!$user) return $this->sendErrors('User with the specified email not found', 404)
            ->setStatusCode(404);

        $products = Product::whereIn('id', $request->products)->get();
        if (count($products) < 1) return $this->sendErrors('Selected products not found', 404)
            ->setStatusCode(404);

        DB::beginTransaction();
        try {
            $coupon = Coupon::create([
                'discount_percentage' => $request->discount,
                'code' => Str::random(10),
                'user_id' => $user->id,
            ]);

            foreach($products as $product) {
                CouponProduct::create([
                    'coupon_id' => $coupon->id,
                    'product_id' => $product->id,
                ]);
            }

            DB::commit();
            return $this->sendResponse('coupon created successfully', $coupon, 201)
                ->setStatusCode(201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendErrors($th->getMessage(), 500)->setStatusCode(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
