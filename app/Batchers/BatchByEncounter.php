<?php
namespace App\Batchers;

use Carbon\Carbon;

class BatchByEncounter extends Batcher {
    public function fulfillOn(): Carbon
    {
        return $this->order->encounter_date;
    }
}
