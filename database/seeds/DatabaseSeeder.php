<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\User',50)->create();
        factory('App\Models\Product',100)->create();
        factory('App\Models\Order',50)->create();
        factory('App\Models\Coupon',100)->create();
    }
}
