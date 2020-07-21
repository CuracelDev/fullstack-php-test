<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {

    return [
        'product_id' => rand(1,50),
        'user_id' => rand(1, 50),
        'price' => rand(1000,100000)
    ];
});
