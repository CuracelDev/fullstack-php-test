<?php

namespace App\DTOs\Requests\SaveOrderItems;

use Spatie\DataTransferObject\DataTransferObject;
class SaveOrderItemsData extends DataTransferObject
{
    public $providerName;

    public $hmo;

    public $encounterDate;

    public $toBeProcessedAt;

    /** @var \App\DTOs\Requests\SaveOrderItems\OrderItemsData[] */
    public  $orderItems;
}
