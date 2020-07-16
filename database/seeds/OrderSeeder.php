<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 50; $i++) {

            App\Models\Order::create([
                'product_id' => rand(1,50),
                'user_id' => rand(1, 50),
                'price' => rand(1000,100000)
            ]);
        }
    }
}
