<?php

namespace Database\Factories;

use App\Enums\BatchCriteria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hmo>
 */
class HmoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hmoName = fake()->company;
        return [
            'name' => $hmoName,
            'code' => Str::slug($hmoName),
            'batch_identified_by' => Arr::random(BatchCriteria::getValues()),
            'email' => fake()->email,
        ];
    }
}
