<?php

namespace Tests\Unit;

use App\Actions\BatchOrder;
use App\Actions\GenerateBatchIdentifier;
use App\Mail\OrderBatchEmail;
use App\Models\Hmo;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BatchOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_that_batch_exists_or_was_created_for_the_order(): void
    {
        Mail::fake();

        $order = Order::factory()->create(['hmo_id' => Hmo::firstWhere('batch_criteria', Hmo::BATCH_CRITERIA_ORDER_DATE)->id]);
        $batchName = "$order->provider_name " . Carbon::parse($order->created_date)->format('M Y');

        GenerateBatchIdentifier::shouldRun($order)
            ->with($order)
            ->andReturn($batchName);

        BatchOrder::run($order);

        $this->assertDatabaseHas('batches', [
            'name' => $batchName,
        ]);
    }

    /**
     * @test
     */
    public function test_that_batch_id_was_assigned_to_the_order(): void
    {
        Mail::fake();

        $order = Order::factory()->create(['hmo_id' => Hmo::firstWhere('batch_criteria', Hmo::BATCH_CRITERIA_ORDER_DATE)->id]);
        $batchName = "$order->provider_name " . Carbon::parse($order->created_date)->format('M Y');

        GenerateBatchIdentifier::shouldRun($order)
            ->with($order)
            ->andReturn($batchName);

        BatchOrder::run($order);

        $this->assertNotNull($order->batch_id);
    }

    /**
     * @test
     */
    public function test_that_mail_was_sent_to_hmo_after_batch_order(): void
    {
        Mail::fake();

        $order = Order::factory()->create(['hmo_id' => Hmo::firstWhere('batch_criteria', Hmo::BATCH_CRITERIA_ENCOUNTER_DATE)->id]);
        $batchName = "$order->provider_name " . Carbon::parse($order->encounter_date)->format('M Y');

        GenerateBatchIdentifier::shouldRun($order)
            ->with($order)
            ->andReturn($batchName);

        BatchOrder::run($order);

        Mail::assertSent(function (OrderBatchEmail $mail) use ($order, $batchName) {
            return $mail->introduction === "New Batch Alert: {$batchName}" && 
                   $mail->message === "{$order->provider_name} has placed an order and it has been batched with identifier: {$batchName}" &&
                   $mail->hasTo($order->hmo->email);
        });
    }
}
