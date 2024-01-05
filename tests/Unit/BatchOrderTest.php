<?php

namespace Tests\Unit;

use App\Actions\BatchOrder;
use App\Actions\CreateOrder;
use App\Actions\NotifyCreatedOrder;
use App\Actions\ProcessOrder;
use App\Constants\FulfilmentType;
use App\Constants\Status;
use App\Dto\CreateOrderDto;
use App\Dto\OrderDto;
use App\Dto\OrderItemDto;
use App\Dto\OrderItemsDto;
use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class BatchOrderTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_order_is_batched_by_encounter_date()
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

    public function test_order_is_batched_by_created_date()
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

    public function test_order_is_dispatched_for_notification_and_batching_after_creation()
    {
        Bus::fake();
        $hmo = Hmo::factory()->create();
        $orderDto = new OrderDto($hmo->code, $this->faker->company, $this->faker->date());
        $orderItemsDto = new OrderItemsDto([
            new OrderItemDto(
                $this->faker->name,
                $this->faker->numberBetween(100, 1000),
                $this->faker->numberBetween(5, 15)
            ),
            new OrderItemDto(
                $this->faker->name,
                $this->faker->numberBetween(100, 1000),
                $this->faker->numberBetween(5, 15)
            )
        ]);
        $order = CreateOrder::run(new CreateOrderDto($orderDto, $orderItemsDto));
        $this->assertTrue($order->status === Status::PENDING);
        $this->assertFalse($order->batch()->exists());

        Bus::assertChained([
            NotifyCreatedOrder::makeJob($order)->onQueue("notifications"),
            BatchOrder::makeJob($order)->onQueue("batchers")
        ]);
    }

    public function test_order_is_dispatched_to_be_processed_after_batching()
    {
        Queue::fake();
        $order = Order::factory()
            ->for(Hmo::factory())
            ->create();
        $order = BatchOrder::run($order->refresh());
        $this->assertTrue($order->status === Status::QUEUED);
        $this->assertTrue($order->batch()->exists());

        ProcessOrder::assertPushedOn("orders", 1);
    }
}
