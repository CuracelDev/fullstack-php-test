<?php

namespace Tests\Feature\Controllers;

use App\Enums\OrderStatus;
use App\Mail\NewOrderNotification;
use App\Models\Batch;
use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_an_order_and_sends_notification_email()
    {
        $this->withExceptionHandling();
        Mail::fake();
        User::factory()->create();
        Batch::factory()->create();
        $provider = Provider::factory()->create();
        $hmo = Hmo::factory()->create();

        $data = [
            'provider_code' => $provider->code,
            'hmo_code' => $hmo->code,
            'status' => OrderStatus::PENDING->value,
            'items' => [
                [
                    'name' => 'Item 1',
                    'price' => 10.0,
                    'quantity' => 1,
                ],
            ],
            'encounter_date' => '2023-03-11',
            'sent_date' => '2023-03-11',
        ];
        auth()->loginUsingId(1);

        $response = $this->post('/api/orders', $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Order submitted successfully']);

        $order = Order::latest()->first();

        Mail::assertQueued(NewOrderNotification::class);


        $this->assertInstanceOf(Order::class, $order);
    }

    /** @test */
    public function it_returns_error_response_when_provider_id_is_missing()
    {
        $provider = Provider::factory()->create();
        $hmo = Hmo::factory()->create();
        User::factory()->create();

        $data = [
            'hmo_code' => $provider->code,
            'status' => OrderStatus::PENDING->value,
            'items' => [
                [
                    'name' => 'Item 1',
                    'price' => 10.0,
                    'quantity' => 1,
                ],
            ],
            'encounter_date' => '2023-03-11',
            'sent_date' => '2023-03-11',
        ];


        auth()->loginUsingId(1);

        $response = $this->postJson('/api/orders', $data);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'The provider code field is required. (and 1 more error)']);
        $this->assertArrayHasKey('provider_code', $response->json()['errors']);
    }

    /** @test */
    public function it_returns_error_response_when_hmo_id_is_missing()
    {
        User::factory()->create();
        $data = [
            'provider_code' => Provider::factory()->create()->code,
            'status' => OrderStatus::PENDING->value,
            'items' => [
                [
                    'name' => 'Item 1',
                    'price' => 10.0,
                    'quantity' => 1,
                ],
            ],
            'encounter_date' => '2023-03-11',
            'sent_date' => '2023-03-11',
        ];

        auth()->loginUsingId(1);


        $response = $this->postJson('/api/orders', $data);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'The hmo code field is required.']);
        $this->assertArrayHasKey('hmo_code', $response->json()['errors']);
    }

    /** @test */
    public function it_does_not_create_an_order_with_invalid_data()
    {
        User::factory()->create();
        auth()->loginUsingId(1);
        Mail::fake();

        $data = [
            'provider_id' => 'invalid_provider_code',
            'hmo_id' => 'invalid_hmo_code',
            'status' => 'invalid_status',
            'items' => 'invalid_items',
            'encounter_date' => 'invalid_encounter_date',
            'sent_date' => 'invalid_sent_date',
        ];

        $response = $this->postJson('/api/orders', $data);

        $response->assertStatus(422);

        Mail::assertNotSent(NewOrderNotification::class);
    }
}
