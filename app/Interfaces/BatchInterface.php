<?php

namespace App\Interfaces;

use App\Models\Order;

interface BatchInterface
{
    public static function create(Order $order, string $criteria): void;
}
