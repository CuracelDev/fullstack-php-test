<?php

namespace Database\Factories;

use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider' => $this->faker->company,
            'items' => [
                [
                    "name"  => $this->faker->word,
                    "unit_price" => $this->faker->randomNumber(2, true),
                    "quantity" => $this->faker->randomNumber(2, true),
                    "sub_total" => $this->faker->randomNumber(2, true)
                ],
                [
                    "name"  => $this->faker->word,
                    "unit_price" => $this->faker->randomNumber(2, true),
                    "quantity" => $this->faker->randomNumber(2, true),
                    "sub_total" => $this->faker->randomNumber(2, true)
                ]
            ],
            'hmo_id' => Hmo::factory(),
            'total' => $this->faker->randomFloat(2),
            'encounter_date' => $this->faker->date('d-m-Y'),
            'hmo_batch_id' => null
        ];
    }
}
