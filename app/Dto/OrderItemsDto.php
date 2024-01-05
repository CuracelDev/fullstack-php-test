<?php

namespace App\Dto;

use App\Dto\Base\CollectionDto;
use App\Dto\Base\Dto;

class OrderItemsDto extends CollectionDto
{
    public function __construct(?array $items = [])
    {
       parent::__construct($items);
    }

    protected function item(array $item = []): Dto
    {
        return (new OrderItemDto())->fromArray($item);
    }

    public function transform(): OrderItemsDto
    {
        return $this;
    }

    public function validate(): OrderItemsDto
    {
        return $this;
    }
}
