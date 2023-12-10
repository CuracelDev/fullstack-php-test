<?php

namespace App\DTOs\Requests\SaveOrderItems;

use Spatie\DataTransferObject\DataTransferObject;

class OrderItemsData extends DataTransferObject
{
    public $name;

    public $unit_price;

    public $quantity;

    public $sub_total;
}
