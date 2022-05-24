<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hmo;
use Str;

class HmoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Hmo::class;

    public function definition()
    {
        $name = $this->faker->name();
        $code =  implode('', array_map(function($v) { return $v[0]; }, explode(' ', $name)));
        return [
            'name' => $name, 
            'code' => $code,
            'email' => $this->faker->unique()->safeEmail(),
            'batch_rule' => $this->faker->randomElement(['encounter_date', 'request_date'])
        ];
    }

    public function batchByEncounterDate()
    {
        return $this->state(function (array $attributes) {
            return [
                'batch_preference' => 'encounter_date',
            ];
        });
    }

    public function batchByRequestDate()
    {
        return $this->state(function (array $attributes) {
            return [
                'batch_preference' => 'request_date',
            ];
        });
    }
}
