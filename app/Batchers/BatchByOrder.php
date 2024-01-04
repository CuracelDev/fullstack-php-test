<?php
namespace App\Batchers;

use Carbon\Carbon;

class BatchByOrder extends Batcher {
    public function fulfillOn(): Carbon
    {
        return $this->order->created_at;
    }
}
