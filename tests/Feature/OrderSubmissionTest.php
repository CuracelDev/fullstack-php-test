<?php

namespace Tests\Feature;

use App\Models\Hmo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that order can be submitted successfully
     *
     * @return void
     */
    public function test_successful_order_submission(): void
    {
        $hmo = Hmo::factory()->create(['batching_rule' => 'encounter_month']);

        $orderData = [
            'hmo_code' => $hmo->code,
            'encounter_date' => now()->toDateString(),
            'provider_name' => 'Test Provider',
            'items' => [
                ['item' => 'Test Item 1', 'unit_price' => 10, 'quantity' => 2],
                ['item' => 'Test Item 2', 'unit_price' => 15, 'quantity' => 1],
            ]
        ];

        $response = $this->postJson('/api/v1/provider/submit-order', $orderData);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [],
        ]);
    }

    public function test_invalid_order_submission(): void
    {
        $orderData = [
            'hmo_code' => null,
            'encounter_date' => null,
            'provider_name' => null,
            'items' => [
                ['item' => 'Test Item 1', 'unit_price' => 10, 'quantity' => 2],
                ['item' => 'Test Item 2', 'unit_price' => 15, 'quantity' => 1],
            ]
        ];

        $response = $this->postJson('/api/v1/provider/submit-order', $orderData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['hmo_code', 'encounter_date', 'provider_name']);
    }
}
