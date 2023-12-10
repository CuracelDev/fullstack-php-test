<?php

namespace App\DTOs\Models;

use App\DTOs\Requests\SaveOrderItems\OrderItemsData;
use Spatie\DataTransferObject\DataTransferObject;

class OrderData extends DataTransferObject
{
    /** @var OrderItemsData */
    public $items;

    public $provider_name;

    public $hmo_id;

    public $total_price;

    public $created_at;
}
