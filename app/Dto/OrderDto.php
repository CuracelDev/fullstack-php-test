<?php

namespace App\Dto;

use App\Dto\Base\ScalarDto;
use App\Models\Hmo;

class OrderDto extends ScalarDto
{
    public ?string $hmo_code;
    public ?string $provider_name;
    public ?string $encounter_date;

    public function __construct(
        ?string $hmo_code = null,
        ?string $provider_name = null,
        ?string $encounter_date = null
    )
    {
        $this->hmo_code = $hmo_code;
        $this->provider_name = $provider_name;
        $this->encounter_date = $encounter_date;
    }

    public function transform(): OrderDto
    {
        $hmo = Hmo::where('code', $this->hmo_code)->first();
        if($hmo) return $this->append(["hmo_id" => $hmo->id]);
        return $this;
    }

    public function validate(): OrderDto
    {
        return $this;
    }

}
