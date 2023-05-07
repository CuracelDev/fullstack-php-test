<?php

namespace Database\Factories;

use App\Enums\BatchType;
use App\Models\Hmo;
use Faker\Generator as Faker;

$factory->define(Hmo::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code' => $faker->randomNumber(5),
        'email' => $faker->unique()->safeEmail,
        'batch_type' => BatchType::ENCOUNTER_DATE()
    ];
});
