<?php

namespace Tests\Unit;

use App\Services\OrderService;
use Tests\TestCase;

class PrepareOrderItemsTest extends TestCase
{
    /**
     * Test that order items are computed and prepared correctly
     *
     * @return void
     */
    public function test_prepare_order_items_calculates_total_price_correctly(): void
    {
        // Create an instance of OrderService
        $orderService = new OrderService();

        // Define some test order items
        $orderItems = [
            ['item' => 'Test Item 1', 'unit_price' => 10, 'quantity' => 2],
            ['item' => 'Test Item 2', 'unit_price' => 15, 'quantity' => 1]
        ];

        // Call the prePareOrderItems() method
        $preparedItems = $orderService->prePareOrderItems($orderItems);

        // Assert that the returned array has the correct structure
        $this->assertIsArray($preparedItems);
        $this->assertCount(2, $preparedItems);

        // Assert that the total price for each item has been calculated correctly
        $this->assertEquals(20, $preparedItems[0]['total_price']); // 10 * 2
        $this->assertEquals(15, $preparedItems[1]['total_price']); // 15 * 1
    }
}
