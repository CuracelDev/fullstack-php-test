<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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

            $frequency_limits = ['annually', 'biannually', 'quarterly', 'monthly', 'bi-monthly'];
            $limit = array_rand($frequency_limits);

            App\Models\Product::create([
                'name' => $faker->name,
                'price' => rand(1000, 100000),
                'pix' => strtolower($faker->name).".jpg",
                'age_limit_status' => 'no',
                'start_age_range' => null,
                'end_age_range' => null,
                'coupon_status' => 'yes',
                'coupon_id' => rand(1, 50),
                'frequency_limit_status' => 'yes',
                'frequency_limit' => $frequency_limits[$limit] 
            ]);
        }

    }
}
