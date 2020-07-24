<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Coupon::class, function (Faker $faker) {
    return [
        'code' => $faker->word() . $faker->randomDigit,
        'discount' => $faker->numberBetween(5, 15),
        'user_id' => factory(User::class),
        'product_id' => factory(Product::class),
    ];
});
