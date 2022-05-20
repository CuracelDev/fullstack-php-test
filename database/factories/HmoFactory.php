<?php

namespace Database\Factories;

use App\Models\Hmo;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class HmoFactory extends Factory
{
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

    public function definition() {
        return [
            'name' => $this->faker->name,
            'code' => Str::random(4)
        ];
    }

}
