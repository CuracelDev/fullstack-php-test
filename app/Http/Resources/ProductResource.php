<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\CommonHelper;

class ProductResource extends JsonResource
{
    use CommonHelper;

    /**
     * Transform the resource into an aarray.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'pix' => $this->pix,
            'age_limit_status' => $this->age_limit_status,
            'start_age_range' => $this->start_age_range,
            'end_age_range' => $this->end_age_range,
            'coupon_status' => $this->coupon_status,
            'coupon_id' => $this->coupon_id,
            'coupon_code' => $this->Coupon->code,
            'coupon_tax' => $this->Coupon->tax,
            'frequency_limit_status' => $this->frequency_limit_status,
            'frequency_limit' => $this->frequency_limit,
            'created_at' => Carbon::parse($this->created_at)->format('F jS, Y, h:i: A'),
            'updated_at' => Carbon::parse($this->updated_at)->format('F jS, Y, h:i: A'),
            'deleted_at' => Carbon::parse($this->deleted_at)->format('F jS, Y, h:i: A'),
        ];
    }
}
