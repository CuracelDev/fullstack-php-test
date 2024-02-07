<?php

namespace Tests\Feature;

use App\Actions\Orders\SendOrderMail;
use App\Models\Order;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendOrderMailTest extends TestCase
{
    use RefreshDatabase;

    public function testNotificationSent()
    {
        $order = Order::factory()->create();

        Notification::fake();
        SendOrderMail::run($order);
        Notification::assertTimesSent(1, OrderCreatedNotification::class);
    }
}
