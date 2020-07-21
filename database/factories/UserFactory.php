<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'email_verified_at' => date('Y-m-d H:i:s'),
        'age' => rand(10, 100),
        'tax' => rand(2, 10),
        'password' => Hash::make('password'),
    ];
});
