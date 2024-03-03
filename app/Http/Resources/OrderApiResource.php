<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderApiResource extends JsonResource
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
            'hmo' => $this->hmo->name,
            'provider' => $this->user_name,
            'order_items' => $this->items,
            'total' => $this->total,
            'encounter_date' => $this->encounter_date->format('F jS, Y'),
            'submitted_at' => $this->created_at->format('F jS, Y'),
            'is_processed' => $this->is_processed
        ];
    }
}
