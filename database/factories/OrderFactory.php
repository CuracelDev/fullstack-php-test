<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Order::class;

    public function definition()
    {
        $items = [
            [
                'item'=> $this->faker->words(3, true),
                'subTotal' => rand(1, 10),
                'quantity' => rand(1, 10),
                'reference' => Str::random(),
                'price' => rand(10, 100),
            ],
            [
                'item'=> $this->faker->words(3, true),
                'subTotal' => rand(1, 10),
                'quantity' => rand(1, 10),
                'reference' => Str::random(),
                'price' => rand(10, 100),
            ]
        ];
        return [
            'encounter_date' => $this->faker->dateTimeBetween('-1 years', now()),
            'items' => json_encode($items),
            'processed' => false,
            'hmo_id' => 1,
            'provider_id' => 1,
        ];
    }
}
