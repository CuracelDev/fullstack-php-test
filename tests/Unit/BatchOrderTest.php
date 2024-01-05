<?php

namespace Tests\Unit;

use App\Actions\BatchOrder;
use App\Constants\FulfilmentType;
use App\Constants\Status;
use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BatchOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_can_be_batched_by_encounter_date()
    {
        $order = Order::factory()
            ->for(Hmo::factory()->state(["fulfil_by" => FulfilmentType::ENCOUNTER]))
            ->create();
        $order = BatchOrder::run($order->refresh());
        $this->assertTrue($order->status === Status::QUEUED);
        $this->assertTrue($order->batch()->exists());
        $this->assertEquals(
            $order->encounter_date->endOfMonth()->format("Y-m-d"),
            $order->batch->to_be_processed_on
        );
    }

    public function test_order_can_be_batched_by_created_date()
    {
        $order = Order::factory()
            ->for(Hmo::factory()->state(["fulfil_by" => FulfilmentType::ORDER]))
            ->create();
        $order = BatchOrder::run($order->refresh());
        $this->assertTrue($order->status === Status::QUEUED);
        $this->assertTrue($order->batch()->exists());
        $this->assertEquals(
            $order->created_at->endOfMonth()->format("Y-m-d"),
            $order->batch->to_be_processed_on
        );
    }
}
