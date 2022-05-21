<?php

namespace Database\Factories;

use App\Models\Order;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
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
    public function definition(){
        return [
            'provider_id' => null,
            'hmo_id' => null,
            'items' =>null,
            'encounter_date'=> now(),
            'total'=>0
        ];
    }

}