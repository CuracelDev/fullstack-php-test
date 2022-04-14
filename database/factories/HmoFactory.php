<?php

namespace Database\Factories;

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
            'name' => $this->faker->company,
            'code' => $this->faker->word,
            'email' => $this->faker->safeEmail,
        ];
    }
}
