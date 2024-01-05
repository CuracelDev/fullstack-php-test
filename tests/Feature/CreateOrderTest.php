<?php

namespace Tests\Feature;

use App\Constants\Status;
use App\Models\Hmo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_order_can_be_created_via_api() {
        $hmo = Hmo::factory()->create();
        $testData = [
            'hmo_code' => $hmo->code,
            'provider_name' => $this->faker->company(),
            'encounter_date' => $this->faker->date(),
            'items' => [
                [
                    "name" => $this->faker->name(),
                    "price" => $this->faker->numberBetween(100,1000),
                    "quantity" => $this->faker->numberBetween(2, 10)
                ]
            ]
        ];
        $response = $this->json('POST', route('order.create'), $testData);
        $response
            ->assertCreated()
            ->assertJsonPath("data.hmo_id", $hmo->getKey())
            ->assertJsonPath("data.provider_name", $testData['provider_name'])
            ->assertJsonPath("data.status", Status::PENDING);
    }

}
