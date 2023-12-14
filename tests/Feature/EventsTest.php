<?php

namespace Tests\Feature;

use App\Actions\BatchOrder;
use App\Events\OrderSubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function that_batch_order_listens_to_order_submitted_event(): void
    { 
        Event::fake();

        Event::assertListening(
            OrderSubmitted::class,
            BatchOrder::class
        );
    }
}
