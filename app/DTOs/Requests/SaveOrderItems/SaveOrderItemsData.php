<?php

namespace App\DTOs\Requests\SaveOrderItems;

use Spatie\DataTransferObject\DataTransferObject;
use App\DTOs\Requests\SaveOrderItems\OrderItemsData;
class SaveOrderItemsData extends DataTransferObject
{
    public $providerName;

    public $hmo;

    public $encounterDate;

    public $toBeProcessedAt;

    /** @var OrderItemsData */
    public  $orderItems;
}
