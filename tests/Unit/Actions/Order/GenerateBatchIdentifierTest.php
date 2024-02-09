<?php

namespace Tests\Unit\Actions\Order;

use App\Actions\Order\GenerateBatchIdentifier;
use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class GenerateBatchIdentifierTest extends TestCase
{
    public function testReturnCorrectBatchIdentifierWithEncounterDatePreference(): void
    {
        $order = Order::factory()
            ->makeOne([
                'hmo_id' => Hmo::firstWhere('batch_preference', Hmo::BATCH_PREFERENCE_ENCOUNTER_DATE)->id
            ]);

        $result = GenerateBatchIdentifier::run($order);

        $this->assertIsString($result);
        $this->assertEquals("$order->provider " . Carbon::parse($order->encounter_date)->format('M Y'), $result);
    }

    public function testReturnCorrectBatchIdentifierWithOrderDatePreference(): void
    {
        $order = Order::factory()
            ->makeOne(['hmo_id' => Hmo::firstWhere('batch_preference', Hmo::BATCH_PREFERENCE_CREATED_DATE)->id]);

        $result = GenerateBatchIdentifier::run($order);

        $this->assertIsString($result);
        $this->assertEquals("$order->provider " . Carbon::parse($order->created_date)->format('M Y'), $result);
    }
}
