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

    public function orders() {
        
    }

    public function add(Request $request) {
 
    }

    public function delete($orderId) {
 
    }
}
