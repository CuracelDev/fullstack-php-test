<?php

namespace Tests\Feature\Actions\Order;

use App\Actions\Order\CreateBatchForHmoOrderAndSendNotification;
use App\Enums\OrderStatus;
use App\Events\OrderCreatedEvent;
use App\Models\Hmo;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    public function testOrderCreatedSuccessfully()
    {
        Event::fake();

        $hmo = Hmo::factory()->createOneQuietly();

        $this->postJson(
            route('orders.create',  $payload = $this->orderPayload(['hmo_id' => $hmo->id]))
        )
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => null
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ]);

        $this->assertDatabaseHas('orders', [
            'provider' => $payload['provider'],
            'hmo_id' => $hmo->id,
            'total' => 400,
            'status' => OrderStatus::PENDING->value,
        ])
            ->assertDatabaseCount('orders', 1);

        Event::assertDispatched(OrderCreatedEvent::class);
        Event::assertListening(OrderCreatedEvent::class, CreateBatchForHmoOrderAndSendNotification::class);
    }

    public function testCannotCreateOrderWithInvalidHmo()
    {
        $this->postJson(
            route('orders.create', $this->orderPayload(['hmo_id' => 13000]))
        )
            ->assertUnprocessable()
            ->assertSeeText('The selected HMO code is invalid.');
    }

    public function testCannotCreateOrderWithInvalidEncounterDate()
    {
        Notification::fake();

        $hmo = Hmo::query()->select('id', 'code')->first();

        $this->postJson(
            route('orders.create', $this->orderPayload(['hmo_id' => $hmo->id, 'encounter_date' => 'invalid']))
        )
            ->assertUnprocessable()
            ->assertSeeText('The Encounter date is not a valid date.');

        Notification::assertSentTimes(OrderCreatedNotification::class, 0);
    }

    protected function orderPayload(array $additional = []): array
    {
        return [
            'provider' => $this->faker->name,
            'encounter_date' => $this->faker->date(),
            'items' => [
                [
                    'item' => $this->faker->word,
                    'quantity' => 2,
                    'price' => 100,
                ],
                [
                    'item' => $this->faker->word,
                    'quantity' => 1,
                    'price' => 200,
                ],
            ],
            ...$additional
        ];
    }
}
