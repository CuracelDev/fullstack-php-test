<?php

namespace Database\Factories;

use App\Enums\HmoBatchCriteria;
use App\Enums\OrderStatus;
use App\Models\Batch;
use App\Models\Hmo;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate random items
        $items = [];
        for ($i = 0; $i < 5; $i++) {
            $items[] = [
                'item' => fake()->word,
                'unit_price' => fake()->randomFloat(2, 10, 100),
                'quantity' => fake()->randomNumber(2),
            ];
        }

        $status = Arr::random(OrderStatus::cases());

        return [
            'provider_id' => Provider::factory(),
            'hmo_id' => Hmo::factory(),
            'batch_id' => Batch::factory(),
            'status' => $status->value,
            'items' => $items,
            'encounter_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'sent_date' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
