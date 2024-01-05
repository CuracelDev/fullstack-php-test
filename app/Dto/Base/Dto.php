<?php

namespace App\Dto\Base;

use App\Contracts\Dto as IDto;

abstract class Dto implements IDto
{
    protected function getProps(): array
    {
        return get_object_vars($this);
    }

    protected function getKeys(): array
    {
        return array_keys($this->getProps());
    }

    public function append($items = []): Dto
    {
        foreach ($items as $key => $value) {
            $this->{$key} = $value;
        }
        return $this;
    }

    public function asArray(): array
    {
        $result = $this->value();
        $keys = $this->getKeys();
        foreach ($keys as $key) {
            $value = $this->{$key};
            if($value instanceof Dto) {
                $result[$key] = $value->value();
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public function asObject() {
        return json_decode(json_encode($this->asArray())) ;
    }
}
