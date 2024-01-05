<?php

namespace Tests\Feature;

use App\Actions\BatchOrder;
use App\Actions\NotifyCreatedOrder;
use App\Constants\Status;
use App\Models\Hmo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_order_is_created_via_api() {
        $hmo = Hmo::factory()->create();
        $requestData = [
            'hmo_code' => $hmo->code,
            'provider_name' => $this->faker->company,
            'encounter_date' => $this->faker->date(),
            'items' => [
                [
                    "name" => $this->faker->name(),
                    "price" => $this->faker->numberBetween(100,1000),
                    "quantity" => $this->faker->numberBetween(2, 10)
                ]
            ]
        ];
        $response = $this->json('POST', route('order.create'), $requestData);
        $response
            ->assertCreated()
            ->assertJsonPath("data.hmo_id", $hmo->getKey())
            ->assertJsonPath("data.provider_name", $requestData['provider_name'])
            ->assertJsonPath("data.status", Status::PENDING);
    }
}
