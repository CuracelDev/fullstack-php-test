<?php

namespace Database\Factories;

use App\Enums\BatchRequirementEnum;
use App\Models\Hmo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class HMOFactory extends Factory
{
    protected $model = Hmo::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name;
        return [
            'name' => $name,
            'code' => Str::slug($name),
            'batch_requirement' => $this->faker->randomElement([BatchRequirementEnum::ENCOUNTER_DATE()->value, BatchRequirementEnum::SENT_DATE()->value]),
            'email' => $this->faker->email
        ];
    }
}
