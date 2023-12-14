<?php

namespace Database\Factories;

use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'provider_name' => $this->faker->company,
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
            'hmo_id' => Hmo::inRandomOrder()->first()->id,
            'order_amount' => $this->faker->randomFloat(2),
            'encounter_date' => $this->faker->date('d-m-Y'),
            'batch_id' => null
        ];
    }
}
