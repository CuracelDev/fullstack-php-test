<?php

namespace Tests\Feature;

use App\Models\Hmo;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateOrderEndPointTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);
    }

    /**
     * Test validation for order creation endpoint.
     *
     * @return void
     */
    public function test_order_creation_validation(): void
    {
        $response = $this->postJson('/api/orders', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'hmo_id',
                'items',
                'encounter_date',
            ]);
    }

    /**
     * Test order creation endpoint.
     *
     * @return void
     */
    public function test_order_creation(): void
    {
        User::factory()->hasHmos(3)->create(['role' => 'hmo']);
        $order = Order::factory()->make();

        $response = $this->postJson('/api/orders', $order->toArray());

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'order' => [
                    'id',
                    'items'
                ]
            ]);

        $this->assertDatabaseHas('orders', [
            'hmo_id' => $order->hmo_id,
            'user_id' => $order->user_id,
            'encounter_date' => $order->encounter_date
        ]);
    }
}
