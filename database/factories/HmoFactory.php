<?php

namespace Database\Factories;

use App\Models\Constants\HmoBatchType;
use App\Models\Hmo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class HmoFactory extends Factory
{
    protected $model = Hmo::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->word(),
            'email' => $this->faker->unique()->safeEmail(),
            'batch_type' => $this->faker->randomElement(HmoBatchType::values()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
