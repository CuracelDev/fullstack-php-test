<?php

namespace App\Dto;

use App\Dto\Base\ScalarDto;
use Illuminate\Http\Request;

class CreateOrderDto extends ScalarDto
{
    public ?OrderDto $order;
    public ?OrderItemsDto $items;

    public function __construct(
        ?OrderDto $order = null,
        ?OrderItemsDto $items = null
    )
    {
        $this->order = $order;
        $this->items = $items;
    }

    public function fromRequest(Request $request): CreateOrderDto
    {
        $this->order = (new OrderDto())->fromRequest($request);
        $this->items = ((new OrderItemsDto())->fromArray($request->get('items')));
        return $this;
    }

    public function transform(): CreateOrderDto
    {
        return $this;
    }

    public function validate(): CreateOrderDto
    {
        return $this;
    }
}
