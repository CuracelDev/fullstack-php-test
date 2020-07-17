<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Repositories\OrderRepository;

class OrderController extends Controller
{
    protected $order;

    public function __construct(
        OrderRepository $order
    ) {
        $this->order = $order;
    }

    public function myOrders(Request $request) {
        $userId = $this->getUserIdFromToken($request);
        $orders = $this->order->getUserOrders($userId);
        return $this->success($orders);
    }

    public function addToCart(Request $request) {
        $userId = $this->getUserIdFromToken($request);
        $cart = $this->order->addToCart($request, $userId);
        return $cart;
    }

    public function delete($orderId) {
 
    }
}
