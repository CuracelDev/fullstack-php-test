<?php

namespace App\Http\Repositories;
use App\Http\CommonHelper;
use App\Models\Order;
use DB;
use Validator;

class OrderRepository
{
    use CommonHelper;
    
    protected $order;

    public function __construct(
        Order $order
    ) {
        $this->order = $order;
    }

    public function orders() {
    
    }

    public function add($data) {
        
    }

    public function delete($orderId) {
        
    }
}
