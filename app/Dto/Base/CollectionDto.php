<?php

namespace App\Dto\Base;

abstract class CollectionDto extends Dto
{
    private ?array $items;
    public function __construct(?array $items) {
        $this->items = $items;
    }
    abstract protected function item(array $item): Dto;
    public function fromArray($arr = []): CollectionDto
    {
        $this->items = array_map(function($item) {
            return $this->item($item);
        }, $arr);
        return $this;
    }

    public function value(): array
    {
        return array_map(function($item) {
            if($item instanceof Dto) {
                return $item->asArray();
            }
            return [];
        }, $this->items);
    }
}
