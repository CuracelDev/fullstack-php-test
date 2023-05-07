<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use stdClass;

class BatchHmoData
{

    protected Collection $hmodata;

    public function __construct(Collection $hmoData)
    {
        $this->hmodata = $hmoData;
    }

    public function toArray(): array
    {
        return $this->hmodata->map(function (stdClass $data) {
            return [
                'group_name' => $data->hmo_group,
                'total_price' => $data->total_price,
                'order_count' => $data->orders_count,
                'order_items_count' => $data->order_items_count
            ];
        })->toArray();
    }
}
