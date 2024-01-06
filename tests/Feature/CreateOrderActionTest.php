<?php

namespace Tests\Feature;

use App\Mail\OrderCreatedNotification;
use App\Models\Hmo;
use App\Models\Order;
use Database\Seeders\HmoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CreateOrderActionTest extends TestCase
{
    use WithFaker;

    /**
     * Set up the test case.
     *
     * This method is called before each test method is executed.
     * It calls the parent's setUp method and seeds the HmoSeeder.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(HmoSeeder::class);
    }

    /**
     * Test case for creating an order successfully.
     *
     * @return void
     */

    public function test_create_order_successfully()
    {
        Mail::fake();

        $hmo = Hmo::select('id', 'code')->first();

        $createOrderPayload = [
            'provider_name' => $this->faker->name,
            'hmo_code' => $hmo->code,
            'encounter_date' => $this->faker->date(),
            'items' => [
                [
                    'item' => 'Paracetamol',
                    'quantity' => 2,
                    'price' => 100,
                ],
                [
                    'item' => 'Amoxilin',
                    'quantity' => 1,
                    'price' => 200,
                ],
            ],
        ];

        $response = $this->postJson('/api/orders', $createOrderPayload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'code',
                'data' => [
                    'id',
                    'provider',
                    'encounter_date',
                    'items',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('hmos', [
            'id' => $hmo->id,
            'is_batched' => true,
        ]);

        $this->assertDatabaseHas('orders', [
            'provider' => $createOrderPayload['provider_name'],
            'encounter_date' => $createOrderPayload['encounter_date'],
            'hmo_id' => $hmo->id,
            'status' => Order::PENDING_STATUS,
        ]);

        $this->assertNotNull(Order::first()->batch_id);

        Mail::assertQueued(OrderCreatedNotification::class);
    }

    /**
     * Test case for creating an order with an invalid HMO code.
     *
     * @return void
     */
    public function test_create_order_with_invalid_hmo_code()
    {
        $createOrderPayload = [
            'provider_name' => $this->faker->name,
            'hmo_code' => 'invalid_hmo_code',
            'encounter_date' => $this->faker->date(),
            'items' => [
                [
                    'item' => 'Paracetamol',
                    'quantity' => 2,
                    'price' => 100,
                ],
                [
                    'item' => 'Amoxilin',
                    'quantity' => 1,
                    'price' => 200,
                ],
            ],
        ];

        $response = $this->postJson('/api/orders', $createOrderPayload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'code',
                'errors' => [
                    'hmo_code',
                ],
            ]);
    }

    /**
     * Test case for creating an order with an invalid encounter date.
     *
     * This test verifies that an order cannot be created with an invalid encounter date.
     * It sends a POST request to the '/api/orders' endpoint with a payload containing an invalid encounter date.
     * The test expects a 422 status code and a specific JSON structure in the response.
     *
     * @return void
     */
    public function test_create_order_with_invalid_encounter_date()
    {
        // Retrieve the first HMO record from the database
        $hmo = Hmo::select('id', 'code')->first();

        // Prepare the payload for creating an order
        $createOrderPayload = [
            'provider_name' => $this->faker->name,
            'hmo_code' => $hmo->code,
            'encounter_date' => 'invalid_encounter_date',
            'items' => [
                [
                    'item' => 'Paracetamol',
                    'quantity' => 2,
                    'price' => 100,
                ],
                [
                    'item' => 'Amoxilin',
                    'quantity' => 1,
                    'price' => 200,
                ],
            ],
        ];

        // Send a POST request to create an order with the payload
        $response = $this->postJson('/api/orders', $createOrderPayload);

        // Assert the response status code and JSON structure
        $response->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'code',
                'errors' => [
                    'encounter_date',
                ],
            ]);
    }

    /**
     * Test case for creating an order with invalid items.
     *
     * @return void
     */
    public function test_create_order_with_invalid_items()
    {
        $hmo = Hmo::select('id', 'code')->first();

        $createOrderPayload = [
            'provider_name' => $this->faker->name,
            'hmo_code' => $hmo->code,
            'encounter_date' => $this->faker->date(),
            'items' => [
                [
                    'item' => 'Paracetamol',
                    'quantity' => 2,
                    'price' => 100,
                ],
                [
                    'item' => 'Amoxilin',
                    'quantity' => 1,
                    'price' => 'invalid_price',
                ],
            ],
        ];

        $response = $this->postJson('/api/orders', $createOrderPayload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'code',
                'errors' => [
                    'items.1.price',
                ],
            ]);
    }

    /**
     * Test case for creating an order with invalid items quantity.
     *
     * @return void
     */
    public function test_create_order_with_invalid_items_quantity()
    {
        $hmo = Hmo::select('id', 'code')->first();

        $createOrderPayload = [
            'provider_name' => $this->faker->name,
            'hmo_code' => $hmo->code,
            'encounter_date' => $this->faker->date(),
            'items' => [
                [
                    'item' => 'Paracetamol',
                    'quantity' => 2,
                    'price' => 100,
                ],
                [
                    'item' => 'Amoxilin',
                    'quantity' => 'invalid_quantity',
                    'price' => 200,
                ],
            ],
        ];

        $response = $this->postJson('/api/orders', $createOrderPayload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'code',
                'errors' => [
                    'items.1.quantity',
                ],
            ]);
    }

    /**
     * Test case for creating an order with validation error.
     *
     * This test verifies that when creating an order with invalid data, the API returns the expected validation error response.
     *
     * @return void
     */
    public function test_create_order_with_validation_error()
    {
        $createOrderPayload = [
            'provider_name' => $this->faker->name,
            'hmo_code' => '',
            'encounter_date' => '',
            'items' => [
                [
                    'item' => '',
                    'quantity' => '',
                    'price' => '',
                ],
            ],
        ];

        $response = $this->postJson('/api/orders', $createOrderPayload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'code',
                'errors' => [
                    'hmo_code',
                    'encounter_date',
                    'items.0.item',
                    'items.0.quantity',
                    'items.0.price',
                ],
            ]);
    }
}
