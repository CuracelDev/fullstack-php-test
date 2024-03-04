<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderFilteringTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory(2)->hasHmos(3)->create(['role' => 'hmo']);
        User::factory(10)->create();
    }

    /**
     * Test filtering of orders by given filter parameters.
     *
     * @test
     */
    public function it_filters_orders_by_given_filter_parameters()
    {
        $date = Carbon::now()->subYear()->subMonth();
        $order = $this->createOrder(['encounter_date' => $date]);

        $filter = [
            'filter_by' => 'encounter_date',
            'month' => $date->format('F'),
            'year' => $date->format('Y'),
        ];

        $filteredOrders = Order::filterBy($filter)->get();

        $this->assertFilteredOrder($order, $filteredOrders);
    }

    /**
     * Test if an empty array is returned when filter parameters don't match any data.
     *
     * @test
     */
    public function it_returns_empty_array_when_filter_parameters_dont_match_any_data()
    {
        $date = Carbon::now()->subYear()->subMonth();
        $order = $this->createOrder(['encounter_date' => $date]);

        $filter = [
            'filter_by' => 'encounter_date',
            'month' => Carbon::now()->format('F'),
            'year' => Carbon::now()->format('Y'),
        ];

        $filteredOrders = Order::filterBy($filter)->get();

        $this->assertDatabaseHasOrder($order);
        $this->assertEmpty($filteredOrders);
    }

    /**
     * Create a new order with the given attributes.
     *
     * @param array $attributes
     * @return Order
     */
    protected function createOrder($attributes = [])
    {
        return Order::factory()->create($attributes);
    }

    /**
     * Assert that the filtered orders contain the expected order.
     *
     * @param Order $expectedOrder
     * @param Collection $filteredOrders
     */
    protected function assertFilteredOrder($expectedOrder, $filteredOrders)
    {
        $this->assertCount(1, $filteredOrders);
        $this->assertEquals($expectedOrder->id, $filteredOrders->first()->id);
    }

    /**
     * Assert that the database has the specified order.
     *
     * @param Order $order
     */
    protected function assertDatabaseHasOrder($order)
    {
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }
}
