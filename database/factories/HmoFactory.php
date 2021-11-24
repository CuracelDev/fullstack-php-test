<?php

namespace Database\Factories;

use App\Models\Hmo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class HmoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hmo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(), 
            'code' => strtoupper($this->faker->unique()->word() . "-" . Str::random(2)),
            'email' => $this->faker->unique()->safeEmail(),
            'batch_preference' => $this->faker->randomElement(['encounter_date', 'date_created'])
        ];
    }

    public function batchOrdersByEncounterDate()
    {
        return $this->state(function (array $attributes) {
            return [
                'batch_preference' => 'encounter_date',
            ];
        });
    }

    public function batchOrdersByDateCreated()
    {
        return $this->state(function (array $attributes) {
            return [
                'batch_preference' => 'date_created',
            ];
        });
    }
}
