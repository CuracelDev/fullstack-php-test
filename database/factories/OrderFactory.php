<?php

namespace Database\Factories;

use App\Models\Hmo;
use App\Models\Order;
use App\Models\User;
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
        $items = [];
        $sub_totals = [];

        for ($i = 0; $i < 5; $i++) {
            $price = number_format($this->faker->randomFloat(2, 1, 100), 2);
            $quatity = $this->faker->randomNumber(2);
            $sub_total = $price * $quatity;
            $sub_totals[] = $sub_total;

            $items[] = [
                'name' => $this->faker->word,
                'unit_price' => $price,
                'quantity' => $quatity,
                'sub_totak' => $sub_total
            ];
        }

        // Generate random encounter date between January 2024 and current date
        $startDate = '2024-01-01';
        $endDate = now();
        $encounterDate = $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d H:i:s');

        return [
            'hmo_id' => Hmo::inRandomOrder()->first()->id,
            'user_id' => User::whereRole('provider')->inRandomOrder()->first()->id,
            'items' => $items,
            'total' => array_sum($sub_totals),
            'encounter_date' => $encounterDate,
        ];
    }
}
