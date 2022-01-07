<?php

namespace Database\Factories;

use App\Models\Hmo;
use App\Models\Batch;
use Illuminate\Database\Eloquent\Factories\Factory;

class BatchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Batch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $hmoId = Hmo::all()->random();

        return [
            'hmo_id' => $hmoId->id,
            'encounter_date' => $this->faker->dateTimeBetween('-1 years', now()),
            'order_ids' => [
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
