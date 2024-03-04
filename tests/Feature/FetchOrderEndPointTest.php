<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class FetchOrderEndPointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up the necessary data for testing.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create users
        User::factory()->create(['role' => 'provider']);
        User::factory()->hasHmos(5)->create(['role' => 'hmo']);

        // Create orders for the provider user
        Order::factory()->count(5)->create(['encounter_date' => now()->subMonth()]);
    }

    /**
     * Test fetching orders filtered by encounter date for an authenticated user.
     *
     * @test
     */
    public function it_returns_orders_filtered_by_encounter_date_for_authenticated_user()
    {
        $provider = User::whereRole('provider')->first();

        $queryString = http_build_query([
            'filter_by' => 'encounter_date',
            'month' => now()->format('F'),
            'year' => now()->format('Y')
        ]);

        $response = $this->actingAs($provider)->getJson("/api/orders?$queryString");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                '*' => [
                    'hmo',
                    'provider',
                    'order_items' => [
                        '*' => [
                            'name',
                            'quantity',
                            'sub_total',
                            'unit_price',
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Test not returning orders for an unauthenticated user.
     *
     * @test
     */
    public function it_does_not_return_orders_for_unauthenticated_user()
    {
        $response = $this->getJson('/api/orders');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}

