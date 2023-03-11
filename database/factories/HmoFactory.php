<?php

namespace Database\Factories;

use App\Enums\HmoBatchCriteria;
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
        $name = fake()->company();
        $batchCriteria = Arr::random(HmoBatchCriteria::cases());

        return [
            'name' => $name,
            'code' => Str::slug($name),
            'batch_by' => $batchCriteria->value,
            'email' => fake()->email,
        ];
    }
}
