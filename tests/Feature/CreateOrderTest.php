<?php

namespace Tests\Feature;

use App\Models\Hmo;
use App\Models\Order;
use Database\Seeders\HmoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testValidationErrors()
    {
        $this->postJson(route('api.orders.store'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['hmo', 'provider', 'items', 'encountered_at']);
    }

    public function testOrderCreatedSuccessfully()
    {
        $this->seed(HmoSeeder::class);

        $data = [
            'hmo' => Hmo::first()->code,
            'provider' => $this->faker->company,
            'encountered_at' => $this->faker->date(),
            'items' => [
                [
                    'name' => $this->faker->lexify(),
                    'price' => $this->faker->randomFloat(2),
                    'qty' => $this->faker->randomNumber(),
                ],
            ],
        ];

        $this->postJson(route('api.orders.store'), $data)
            ->assertCreated()
            ->assertJsonFragment(['message' => 'Order Created']);

        $this->assertDatabaseCount(Order::class, 1);
    }
}
