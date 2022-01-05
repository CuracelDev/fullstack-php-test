<?php

namespace Database\Factories;

use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
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
        $hmoId = Hmo::all()->random();
        $providerId = Provider::all()->random();
        return [
            'hmo_id' => $hmoId->id,
            'provider_id' => $providerId->id,
            'encounter_date' => $this->faker->dateTimeBetween('-1 years', now()),
            'items' => [
                [
                    'item' => $this->faker->words(3, true),
                    'totalPrice' => 18,
                    'quantity' => 5,
                    'subTotal' => 3
                ]
            ],
        ];
    }
}
