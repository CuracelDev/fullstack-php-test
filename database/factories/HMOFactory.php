<?php

namespace Database\Factories;

use App\Models\HMO;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class HMOFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HMO::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'code' => strtoupper(
                $this->faker->unique()->lexify('???') . "-" . Str::random(2)
            ),
            'email' => $this->faker->unique()->safeEmail(),
            'batch_pref' => $this->faker->randomElement(
                [
                    'encounter_date', 'date_created'
                ]
            )
        ];
    }

    /**
     * This make the feild batch_pref to be date_created
     * 
     * @return array
     */
    public function ordersByDateCreated()
    {
        return $this->state(
            function (array $attributes) {
                return [
                    'batch_pref' => 'date_created',
                ];
            }
        );
    }

    /**
     * This make the feild batch_pref to be encounter_date
     * 
     * @return array
     */
    public function ordersByEncounterDate()
    {
        return $this->state(
            function (array $attributes) {
                return [
                    'batch_pref' => 'encounter_date',
                ];
            }
        );
    }
}
