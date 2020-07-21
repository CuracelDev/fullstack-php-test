<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Coupon;
use Faker\Generator as Faker;
use App\Http\CommonHelper;

$factory->define(Coupon::class, function (Faker $faker) {

    return [
        'code' => strtoupper(CommonHelper::generateRandomChars(15)),
        'tax' => rand(10, 80),
    ];
});
