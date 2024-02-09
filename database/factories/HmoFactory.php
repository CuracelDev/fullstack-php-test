<?php

namespace Database\Factories;

use App\Models\Hmo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hmo>
 */
class HmoFactory extends Factory
{
    protected $model = Hmo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->name,
            'code' => Str::slug($name),
            'email' => $this->faker->safeEmail,
            'batch_preference' => $this->faker->randomElement([
                Hmo::BATCH_PREFERENCE_ENCOUNTER_DATE,
                Hmo::BATCH_PREFERENCE_CREATED_DATE
            ])
        ];
    }
}
