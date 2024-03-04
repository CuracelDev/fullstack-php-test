<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HmoApiResource extends JsonResource
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
            'text' => $this->code . ' (' . $this->name . ')',
            'code' => $this->code
        ];
    }
}
