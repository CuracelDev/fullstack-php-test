<?php

namespace Tests\Unit;

use App\Exceptions\ClientErrorException;
use App\Models\Hmo;
use App\Models\Order;
use App\Services\BatchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComputeIndentifierTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_compute_batch_identifier_encounter_month_rule()
    {
        // Arrange
        $service = new BatchService();

        $hmo = Hmo::factory()->create(['batching_rule' => 'encounter_month']);

        $order = Order::factory()->create(['provider_name' => 'Test Provider']);

        // Act
        $batchIdentifier = $service->computeBatchIdentifier($order, $hmo);

        // Assert
        $this->assertEquals('Test Provider Feb 2024', $batchIdentifier);
    }

    public function test_compute_batch_identifier_month_filed_rule()
    {
        // Arrange
        $service = new BatchService();

        $hmo = Hmo::factory()->create(['batching_rule' => 'month_filed']);

        $order = Order::factory()->create(['provider_name' => 'Test Provider']);

        // Act
        $batchIdentifier = $service->computeBatchIdentifier($order, $hmo);

        // Assert
        $this->assertEquals('Test Provider Mar 2024', $batchIdentifier);
    }

}
