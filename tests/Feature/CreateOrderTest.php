<?php

namespace Tests\Feature;

use App\Models\Hmo;
use App\Models\Order;
use App\Notifications\OrderCreatedNotification;
use Database\Seeders\HmoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private function orderData($data = []): array
    {
        return [
            'hmo' => $data['hmo'] ?? Hmo::first()->code,
            'provider' => $data['provider'] ?? $this->faker->company,
            'encountered_at' => $data['encountered_at'] ?? $this->faker->date(),
            'items' => $data['items'] ?? [
                    [
                        'name' => $this->faker->lexify(),
                        'price' => $this->faker->randomFloat(2),
                        'qty' => $this->faker->randomNumber(),
                    ],
                ],
        ];
    }

    public function testValidationErrors()
    {
        $this->postJson(route('api.orders.store'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['hmo', 'provider', 'items', 'encountered_at']);
    }

    public function testOrderCreatedSuccessfully()
    {
        $this->seed(HmoSeeder::class);

        $this->postJson(route('api.orders.store'), $this->orderData())
            ->assertCreated()
            ->assertJsonFragment(['message' => 'Order Created']);

        $this->assertDatabaseCount(Order::class, 1);
    }

    public function testOrderNotificationSent()
    {
        $this->seed(HmoSeeder::class);

        $hmo = Hmo::inRandomOrder()->first();

        Notification::fake();

        $this->postJson(route('api.orders.store'), $this->orderData(['hmo' => $hmo->code]))
            ->assertCreated();

        Notification::assertSentTo($hmo, OrderCreatedNotification::class);
    }
}
