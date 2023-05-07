<?php

namespace Database\Factories;

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'encounter_date' => $faker->date()
    ];
});
