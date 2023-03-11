<?php

namespace Tests\Unit\Services\Batches;

use App\Enums\HmoBatchCriteria;
use App\Models\Batch;
use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use App\Services\Batches\EncounterDateBatch;
use App\Services\Batches\SentDateBatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class BatchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_sent_date_batch_for_order()
    {
        $order = Order::factory()->create();
        $order = Order::find($order->id);
        $batchService = new SentDateBatch();
        $batchService->create($order);

        $batch = Batch::find(2);
        $provider = Provider::find($batch->provider_id);
        $hmo = Hmo::find($batch->hmo_id);

        $this->assertNotNull($batch);
        $this->assertEquals($provider->id, $batch->provider_id);
        $this->assertEquals($hmo->id, $batch->hmo_id);
        $this->assertEquals('submit_date', $batch->criteria);
        $this->assertEquals(Carbon::now()->format('F Y'), $batch->month);

        $this->assertEquals($batch->id, $order->batch_id);
    }

    /** @test */
    public function it_creates_encounter_date_batch_for_order()
    {
        $order = Order::factory()->create();
        $order = Order::find($order->id);
        $batchService = new EncounterDateBatch();
        $batchService->create($order);

        $batch = Batch::find(2);
        $provider = Provider::find($batch->provider_id);
        $hmo = Hmo::find($batch->hmo_id);

        $this->assertNotNull($batch);
        $this->assertEquals($provider->id, $batch->provider_id);
        $this->assertEquals($hmo->id, $batch->hmo_id);
        $this->assertEquals('encounter_date', $batch->criteria);
        $this->assertEquals(Carbon::createFromDate($order->encounter_date)->format('F Y'), $batch->month);

        $this->assertEquals($batch->id, $order->batch_id);
    }
}
