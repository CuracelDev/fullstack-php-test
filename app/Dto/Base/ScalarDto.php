<?php

namespace App\Dto\Base;
use Illuminate\Http\Request;

abstract class ScalarDto extends Dto
{
    public function fromRequest(Request $request): ScalarDto
    {
        return $this->fromArray($request->only($this->getKeys()));
    }
    public function fromArray($arr = []): ScalarDto
    {
        $keys = array_keys($arr);
        foreach ($keys as $key) {
            if(property_exists($this, $key)) {
                $this->{$key} = $arr[$key];
            }
        }
        return $this;
    }

    public function value(): array
    {
        return $this
            ->transform()
            ->validate()
            ->getProps();
    }
}
