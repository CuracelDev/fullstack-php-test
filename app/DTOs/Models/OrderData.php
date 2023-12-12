<?php

namespace App\DTOs\Models;

use Spatie\DataTransferObject\DataTransferObject;

class OrderData extends DataTransferObject
{
    public $provider_name;

    public $hmo_id;

    public $total_price;

    public $created_at;

    /** @var \App\DTOs\Requests\SaveOrderItems\OrderItemsData[] */
    public $items;

}


