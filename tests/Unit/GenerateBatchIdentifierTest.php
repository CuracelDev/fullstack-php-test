<?php

namespace Tests\Unit;

use App\Actions\GenerateBatchIdentifier;
use App\Models\Hmo;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateBatchIdentifierTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_order_processed_returns_correct_identifier_with_encounter_date_criteria(): void
    {
        $order = Order::factory()->create(['hmo_id' => Hmo::firstWhere('batch_criteria', Hmo::BATCH_CRITERIA_ENCOUNTER_DATE)->id]);

        $result = GenerateBatchIdentifier::run($order);

        $this->assertIsString($result);
        $this->assertEquals("$order->provider_name " . Carbon::parse($order->encounter_date)->format('M Y'), $result);
    }

    /** @test */
    public function test_order_processed_returns_correct_identifier_with_order_date_criteria(): void
    {
        $order = Order::factory()->create(['hmo_id' => Hmo::firstWhere('batch_criteria', Hmo::BATCH_CRITERIA_ORDER_DATE)->id]);

        $result = GenerateBatchIdentifier::run($order);

        $this->assertIsString($result);
        $this->assertEquals("$order->provider_name " . Carbon::parse($order->created_date)->format('M Y'), $result);
    }
}
