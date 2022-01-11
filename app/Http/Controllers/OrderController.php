<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Traits\ManagesResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use ManagesResponse;

    public function index(Request $request)
    {
        $user = $request->user;
        $orders = Order::where('user_id', $user->id)->with(['coupon', 'user', 'product'])->latest()->get();
        return $this->sendResponse('Orders fetched', $orders, 200)->setStatusCode(200);
    }

    public function store(Request $request)
    {
        if (!$this->userBalace($request)) {
            return $this->sendErrors('Insufficient balance', 403)->setStatusCode(403);
        }

        if (!$this->checkProductCoupons($request)) {
            $message = 'Some products in your carts needs a coupon code';
            return $this->sendErrors($message, 403)->setStatusCode(403);
        }

        if (!$this->checkAgeLimit($request)) {
            $message = 'Some products in your cart are above your age limit';
            return $this->sendErrors($message, 403)->setStatusCode(403);
        }

        $purchase_frequency = $this->purchaseFrequencyLimit($request);
        if ($purchase_frequency['success'] === 'false') {
            $frequency = $purchase_frequency['frequency'] === '1' ? 'time' : 'times';
            $time = $purchase_frequency['frequency'] . ' ' . $frequency . ' in '
                . $purchase_frequency['time_limit'] . ' ' . $purchase_frequency['duration'];
            $message = 'You can only purchase ' . $purchase_frequency['product'] . ' only ' . $time;
            return $this->sendErrors($message, 403)->setStatusCode(403);
        }

        DB::beginTransaction();
        try {
            $order_id = Str::random(10);
            foreach ($request->products as $product) {
                Order::create([
                    'order_id' => $order_id,
                    'user_id' => $request->user->id,
                    'product_id' => $product['id'],
                    'amount' => $request->amount,
                ]);
            }

            User::where('user_id', $request->user->id)->update([
                'balance' => $request->amount
            ]);

            DB::commit();
            return $this->sendResponse('Order placed successfully', [], 201)
                ->setStatusCode(201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendErrors($th->getMessage(), 500)->setStatusCode(500);
        }
    }

    private function userBalace($request)
    {
        return ($request->user->balance >= $request->amount);
    }

    private function productIds($request) {
        $carts = $request->products;
        $product_ids = [];
        foreach ($carts as $cart) {
            $product_ids[] = $cart['id'];
        };

        return $product_ids;
    }

    private function checkProductCoupons($request) {
        $used_coupons = $request->used_coupon;
        $product_ids = $this->productIds($request);
        $user = $request->user;
        $coupons = Coupon::where('user_id', $user->id)->with(['products'])->get();
        foreach ($coupons as $coupon) {
            foreach ($coupon->products as $product) {
                if (in_array($product->id, $product_ids) && !in_array($coupon->code, $used_coupons)) {
                    return false;
                }
            }
        }

        return true;
    }

    private function checkAgeLimit($request) {
        $product_ids = $this->productIds($request);
        $user = $request->user;

        $products = Product::whereIn('id', $product_ids)->get();
        foreach ($products as $product) {
            if ($user->age < $product->age_limit) {
                return false;
            }
        }

        return true;
    }

    private function purchaseFrequencyLimit($request)
    {
        $user = $request->user;
        $product_ids = $this->productIds($request);
        $orders = Order::where('user_id', $user->id)->whereIn('product_id', $product_ids)->get();
        if (count($orders) > 0) {
            $time_limit = '';
            $purchase_frequency = '';
            $duration = '';
            foreach ($orders as $key => $order) {
                $products = Order::where('user_id', $user->id)->where('product_id', $order->product->id)
                    ->with(['product'])->get();
                if (count($products) > 0) {
                    $time_limit .= $products[$key]->product->time_limit;
                    $purchase_frequency .= $products[$key]->product->purchase_frequency;
                    $duration .= $products[$key]->product->duration;
                    $error = [
                        'success' => 'false',
                        'frequency' => $purchase_frequency,
                        'time_limit' => $time_limit,
                        'duration' => $duration,
                        'product' => $products[$key]->product->name,
                    ];
                    $success = ['success' => 'true'];
                    if ($duration === 'Year') {
                        $year = 12;
                        $time_duration = Carbon::now()->diffInMonths($order->created_at);
                        $limit = $purchase_frequency * $time_limit;
                        if ($time_duration < $year && $purchase_frequency > count($products)
                            && $time_limit < $limit) {
                            return $success;
                        }
                        return $error;
                    }

                    if ($duration === 'Months') {
                        $month = 31;
                        $time_duration = Carbon::now()->diffInDays($order->created_at);
                        $limit = $purchase_frequency * $time_limit;
                        if ($time_duration < $month && $purchase_frequency > count($products)
                            && $time_limit < $limit) {
                            return $success;
                        }
                        return $error;
                    }
                }
            }
        }
        return ['success' => 'true'];
    }
}
