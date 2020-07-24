<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'price' => $this->price,
            'coupon_needed' => $this->coupon_needed,
            'age_limit' => $this->age_limit,
            'purchase_limit' => $this->purchase_limit,
        ];
    }
}
