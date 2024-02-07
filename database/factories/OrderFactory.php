<?php

namespace Database\Factories;

use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'batch_id' => $this->faker->word(),
            'items' => [],
            'encountered_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'hmo_id' => Hmo::factory(),
        ];
    }
}
