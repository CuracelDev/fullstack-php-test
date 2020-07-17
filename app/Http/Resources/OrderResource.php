<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\CommonHelper;

class OrderResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product_name' => $this->Product->name,
            'product_price' => $this->Product->price,
            'coupon_id' => $this->Product->coupon_id,
            'coupon_code' => $this->Product->Coupon->code,
            'user_id' => $this->user_id,
            'user_fullname' => $this->User->name,
            'price' => $this->price,
            'created_at' => Carbon::parse($this->created_at)->format('F jS, Y, h:i: A'),
            'updated_at' => Carbon::parse($this->updated_at)->format('F jS, Y, h:i: A'),
            'deleted_at' => Carbon::parse($this->deleted_at)->format('F jS, Y, h:i: A'),
        ];
    }
}
