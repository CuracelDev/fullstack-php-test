<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Provider;

class ProviderFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Provider::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
