<?php
namespace app\Services;

use App\Models\Order;

class OrderService{

    public function create(Array $data)
    {
       return Order::create($data);
    }

}