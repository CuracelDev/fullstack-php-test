<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2),
        'price' => $faker->numberBetween(1000, 9000),
        'details' => $faker->text(),
        'coupon_needed' => $faker->numberBetween(0, 1),
        'age_limit' => $faker->numberBetween(10, 60),
        // 'purchase_limit' => $faker->dateTimeBetween('3 months', '12 months'),
    ];
});
