<?php

namespace Database\Factories;

use App\Constants\FulfilmentType;
use App\Models\Hmo;
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
    public function definition(): array
    {
        return [
            "code" => "hmo-".uniqid(),
            "name" => $this->faker->company(),
            "email" => $this->faker->companyEmail(),
        ];
    }

    public function fulfilByEncounterDate(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'fulfil_by' => FulfilmentType::ENCOUNTER,
            ];
        });
    }
    public function fulfilByOrderDate(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'fulfil_by' => FulfilmentType::ORDER,
            ];
        });
    }
}
