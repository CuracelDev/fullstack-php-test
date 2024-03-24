<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Hmo;
use App\Models\Order;
use App\Services\BatchService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderBatchingTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that an order is successfully batched after creation
     *
     * @return void
     */
    public function test_successful_order_batching(): void
    {
        // Create an HMO
        $hmo = Hmo::factory()->create(['batching_rule' => 'encounter_month']);

        // Create order data
        $orderData = [
            'hmo_code' => $hmo->code,
            'encounter_date' => now()->toDateString(),
            'provider_name' => 'Test Provider',
            'items' => [
                ['item' => 'Test Item 1', 'unit_price' => 10, 'quantity' => 2],
                ['item' => 'Test Item 2', 'unit_price' => 15, 'quantity' => 1],
            ]
        ];

        // Submit the order
        $this->postJson('/api/v1/provider/submit-order', $orderData);

        // Check if the order was processed and added to the correct batch
        $order = Order::where('provider_name', 'Test Provider')->first();
        $this->assertNotNull($order);


        $expectedIdentifier = $order->provider_name . ' ' . date('M Y', strtotime($order->encounter_date));

        // Check if the batch exists and contains the order
        $batch = Batch::whereIdentifier($expectedIdentifier)->whereHmoId($hmo->id)->first();
        $this->assertNotNull($batch);
        $this->assertTrue($batch->orders->contains($order));

    }

    public function test_successful_batching_by_encounter_month_rule()
    {
        // Create an HMO with batching rule 'encounter_month'
        $hmo = Hmo::factory()->create(['batching_rule' => 'encounter_month']);


        // Create an order with encounter date in the current month
        $orderData = [
            'hmo_code' => $hmo->code,
            'encounter_date' => Carbon::now()->subMonth()->startOfMonth()->toDateString(),
            'provider_name' => 'Test Provider',
            'items' => [
                ['item' => 'Test Item 1', 'unit_price' => 10, 'quantity' => 2],
                ['item' => 'Test Item 2', 'unit_price' => 15, 'quantity' => 1],
            ]
        ];

        $response = $this->postJson('/api/v1/provider/submit-order', $orderData);

        // Assert that the order was processed successfully
        $response->assertStatus(200);

        // Get the created order
        $order = Order::first();

        // Assert that a batch has been created with identifier matching encounter month of order
        $this->assertDatabaseHas('batches', [
            'identifier' => app(BatchService::class)->computeBatchIdentifier($order,$hmo),
            'hmo_id' => $hmo->id,
            'total_amount' => $order->total_amount,
        ]);

        $batch = Batch::first();

        $this->assertEquals($batch->identifier, $order->provider_name. " ". date('M Y', strtotime($order->encounter_date)));
    }

    public function test_successful_batching_by_month_filed_rule()
    {
        // Create an HMO with batching rule 'encounter_month'
        $hmo = Hmo::factory()->create(['batching_rule' => 'month_filed']);


        // Create an order with encounter date in the current month
        $orderData = [
            'hmo_code' => $hmo->code,
            'encounter_date' => Carbon::now()->subMonth()->startOfMonth()->toDateString(),
            'provider_name' => 'Test Provider',
            'items' => [
                ['item' => 'Test Item 1', 'unit_price' => 10, 'quantity' => 2],
                ['item' => 'Test Item 2', 'unit_price' => 15, 'quantity' => 1],
            ]
        ];

        $response = $this->postJson('/api/v1/provider/submit-order', $orderData);

        // Assert that the order was processed successfully
        $response->assertStatus(200);

        // Get the created order
        $order = Order::first();

        // Assert that a batch has been created with identifier matching encounter month of order
        $this->assertDatabaseHas('batches', [
            'identifier' => app(BatchService::class)->computeBatchIdentifier($order,$hmo),
            'hmo_id' => $hmo->id,
            'total_amount' => $order->total_amount,
        ]);

        $batch = Batch::first();

        $this->assertEquals($batch->identifier, $order->provider_name. " ". date('M Y', strtotime($order->created_at)));
    }

}
