<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    $frequency_limits = ['annually', 'biannually', 'triannually', 'quarterly', 'monthly', 'bimonthly', 'daily'];
    $limit = array_rand($frequency_limits);

    return [
        'name' => "Product ".$faker->name,
        'price' => rand(1000, 100000),
        'age_limit_status' => 'no',
        'start_age_range' => null,
        'end_age_range' => null,
        'coupon_status' => 'yes',
        'coupon_id' => rand(1, 50),
        'frequency_limit_status' => 'yes',
        'frequency_limit' => $frequency_limits[$limit] 
    ];
});
