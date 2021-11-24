<?php

namespace Database\Factories;

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
            'encounter_date' => $this->faker->dateTimeBetween('-1 years', now()),
            'items' => [
                [
                    'item'=> $this->faker->words(3, true),
                    'totalPrice' => 3,
                    'quantity' => 11,
                    'subTotal' => 33
                ]
            ],
        ];
    }

     /**
     * Indicate that the order is processed.
     *
     * @return array
     */
    public function processed()
    {
        return $this->state(function (array $attributes) {
            return [
                'processed' => true,
            ];
        });
    }
}
