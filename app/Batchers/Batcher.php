<?php

namespace App\Batchers;

use App\Contracts\Batcher as IBatcher;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Str;

abstract class Batcher implements IBatcher {

    protected Order $order;
    public function __construct(Order $order) {
        $this->order = $order;
    }
    public function batchName(): string
    {
        return "{$this->order->provider_name} {$this->fulfillOn()->format('M Y')}";
    }
    public function processOn(): Carbon
    {
        return $this->fulfillOn()->endOfMonth();
    }
    public function processDelay(): ?\DateInterval
    {
        return $this->processOn()->lessThanOrEqualTo(now())
            ? null
            : now()->diff($this->processOn());
    }
}
