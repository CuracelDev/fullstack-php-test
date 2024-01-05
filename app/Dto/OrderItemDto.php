<?php

namespace App\Dto;

use App\Dto\Base\ScalarDto;

class OrderItemDto extends ScalarDto
{
    public ?string $name;
    public ?int $price;
    public ?int $quantity;

    public function __construct(
        ?string $name = null,
        ?string $price = null,
        ?string $quantity = null
    )
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function transform(): OrderItemDto
    {
        return $this;
    }

    public function validate(): OrderItemDto
    {
        return $this;
    }
}
