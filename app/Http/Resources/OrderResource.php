<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'items' => $this->items,
            'total' => $this->total,
            'hmo' => $this->hmo_id,
            'encounter_date' => $this->encounter_date,
            'batch' => $this->batch,
        ];
    }
}
