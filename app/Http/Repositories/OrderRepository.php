<?php

namespace App\Http\Repositories;
use App\Http\CommonHelper;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use DB;
use Validator;

class OrderRepository
{
    use CommonHelper;
    
    protected $order;
    protected $user_repo;
    protected $product_repo;

    public function __construct(
        Order $order,
        UserRepository $user_repo,
        ProductRepository $product_repo
    ) {
        $this->order = $order;
        $this->user_repo = $user_repo;
        $this->product_repo = $product_repo;
    }

    public function getUserOrders($userId) {
        $orders = OrderResource::collection($this->order->whereUserId($userId)->get());
        $all_orders = [];
        $total_price = 0;

        foreach($orders as $order) {
            $total_price+= $order->price;
        }

        $user = $this->user_repo->getUser($userId);
        $vat = ceil(($user->tax / 100) * $total_price);
        
        array_push($all_orders, (object) [
            'orders' => $orders,
            'total_price' => $total_price,
            'vat' => $vat
        ]);

        return $all_orders;
    }

    public function getUserProductOrders($userId, $productId) {
        return $this->order->whereUserId($userId)->whereProductId($productId)->get();
    }

    public function getTimeBoundPurchaseFrequency($userId, $productId, $frequency) {
        $product_orders = $this->getUserProductOrders($userId, $productId);
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        
        $counter = 0;

        foreach($product_orders as $order) {
            $date_ordered = explode(" ", $order->created_at);
            $date_portion = $date_ordered[0];
            $split_date = explode("-", $date_portion);
            
            if($frequency == "annually" || $frequency == "biannually" || $frequency == "triannually" || $frequency == "quarterly") {
                if($year == $split_date[0]) {
                    $counter++;
                }
            } else if($frequency == "monthly" || $frequency == "bimonthly") {
                if($month == $split_date[1]) {
                    $counter++;
                }
            } else if($frequency == "daily") {
                if($day == $split_date[2]) {
                    $counter++;
                }
            }
        }

        if($frequency == "biannually" || $frequency == "bimonthly") {
            if($counter >= 2) return "true";
            return "false";
        } else if($frequency == "triannually") {
            if($counter >= 3) return "true";
            return "false";
        } else if($frequency == "quarterly") {
            if($counter >= 4) return "true";
            return "false";
        } else {
            if($counter == 0) return "false";
            return "true";
        }
    }

    public function addToCart($data, $userId) {
        $rules = [
            'product_id' => 'required',
            'coupon_status' => 'required'
        ];

        $validator = Validator::make($data->all(), $rules);
        $errors = $validator->errors();
        
        if($validator->fails()) {
            foreach($errors->all() as $error) {
                $error_response = ['type' => 'error', 'message' => $error];
                return $error_response;
            }
        } else {
            
            $user = $this->user_repo->getUser($userId);
            $product = $this->product_repo->getProduct($data->product_id);
            $price = $product->price;
            
            $age_filter_options = filter_var(
                $user->age, 
                FILTER_VALIDATE_INT, 
                array(
                    'options' => array(
                        'min_range' => $product->start_age_range, 
                        'max_range' => $product->end_age_range
                    )
                )
            );

            //check age limit
            if($product->age_limit_status == 'yes') {
                
                if(!$age_filter_options) {
                    $error_response = ['type' => 'error', 'message' => 'This product can only be bought by users between the age of '.$product->start_age_range.' and '.$product->end_age_range.' years'];
                    return $error_response;
                }

            }

            //ensure coupon is added for coupon-requiring items
            if($product->coupon_status == 'yes' && $data->coupon_code == '') {
                $error_response = ['type' => 'error', 'message' => 'Coupon must be added before you can buy this product.'];
                return $error_response;
            }

            //crosscheck coupon code and calculate the new price based on coupon discount
            if($data->coupon_status == 'yes') {

                if ($data->coupon_code != $product->coupon->code) {                    
                    $error_response = ['type' => 'error', 'message' => 'Invalid coupon code. Try again.'];
                    return $error_response;
                } else {
                    $coupon_tax = $product->coupon->tax;
                    $coupon_price = ($coupon_tax/100) * $product->price;
                    $price = ceil($product->price - $coupon_price);
                }
            }

            //check time-bound purchase frequency
            if($product->frequency_limit_status == 'yes') {
                $check_frequency_limit = $this->getTimeBoundPurchaseFrequency($userId, $data->product_id, $product->frequency_limit);
                $the_frequency = $this->getTheFrequency($product->frequency_limit);
                
                if($check_frequency_limit == "true") {
                    $error_response = ['type' => 'error', 'message' => 'This product can only be bought '.$the_frequency];
                    return $error_response;
                }
            }

            $order = $this->order->create([
                'product_id' => $data->product_id,
                'user_id' => $userId,
                'price' => $price,
            ]);

            $success_response = [
                'type' => 'success',
                'order' => $order,
            ];

            return $success_response;
        }
    }

    public function deleteOrder($orderId, $userId) {
        $order = $this->order->find($orderId);
        $response;

        if($order) {
            if($order->user_id == $userId) {
                $this->order->whereId($orderId)->delete();
                $response = ['type' => 'success', 'message' => 'Order deleted'];
            } else {
                $response = ['type' => 'error', 'message' => 'Unauthorized access'];
            }
        } else {
            $response = ['type' => 'error', 'message' => 'Order does not exist.'];
        }

        return $response;
    }
}
