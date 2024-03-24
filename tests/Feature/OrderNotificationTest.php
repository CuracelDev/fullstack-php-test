<?php

namespace Tests\Feature;

use App\Models\Hmo;
use App\Notifications\NewOrderNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OrderNotificationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that notification gets sent to HMO when an order is created
     *
     * @return void
     */
    public function test_that_notification_is_sent_after_order_creation()
    {
        Notification::fake();

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

        // Submit order
        $this->postJson('/api/v1/provider/submit-order', $orderData);

        // Assert that the NewOrderNotification notification was sent
        Notification::assertSentTo(
            [$hmo],
            NewOrderNotification::class
        );
    }
}
