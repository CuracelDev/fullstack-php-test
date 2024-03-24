<?php

namespace Database\Factories;

use App\Services\BatchService;
use Illuminate\Database\Eloquent\Factories\Factory;

class HmoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>$name = $this->faker->company,
            'code' => "HMO-" . substr($name, 0, 3),
            'batching_rule' => $this->faker->randomElement(BatchService::getBatchingRules()),
            'email' => $this->faker->companyEmail
        ];
    }
}
