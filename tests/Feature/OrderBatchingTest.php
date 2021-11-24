<?php

namespace Tests\Feature;

use App\Models\Hmo;
use Tests\TestCase;
use App\Models\Provider;
use App\Jobs\ProcessOrder;
use App\Services\BatchOrders;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderBatchingTest extends TestCase
{
    public $hmo;
    public $provider;

    protected function setUp() : void
    {
        parent::setUp();

        $this->hmo = Hmo::factory()->create();
        $this->provider = Provider::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_order_was_queued()
    {
        Queue::fake();

        $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', 'api/orders', [
            'hmoCode' => $this->hmo->code,
            'provider' => $this->provider->name,
            'totalPrice' => 12,
            'encounterDate' => now(),
            'orderItems' => [
                [
                    'item' => 'item 1',
                    'quantity' => 2,
                    'unitPrice' => 3,
                    'totalPrice' => 6,
                ],
                [
                    'item' => 'item N',
                    'quantity' => 2,
                    'unitPrice' => 3,
                    'totalPrice' => 6,
                ],
            ],
        ]);

        $this->travelTo(now()->addMonth());

        (new BatchOrders)();
        
        Queue::assertPushed(ProcessOrder::class, 1);

    }
}
