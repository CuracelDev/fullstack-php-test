<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'unit_price' => $faker->randomNumber(4),
        'quantity' => $faker->randomDigit
    ];
});
