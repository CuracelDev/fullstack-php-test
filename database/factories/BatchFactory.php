<?php

namespace Database\Factories;

use App\Enums\BatchCriteria;
use App\Models\Hmo;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Batch>
 */
class BatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hmo_id' => Hmo::factory(),
            'provider_id' => Provider::factory(),
            'month' => fake()->dateTimeBetween(),
            'criteria' => Arr::random(BatchCriteria::getValues()),
        ];
    }
}
