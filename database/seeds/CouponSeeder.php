<?php

use Illuminate\Database\Seeder;
use App\Http\CommonHelper;

class CouponSeeder extends Seeder
{
    use CommonHelper;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 50; $i++) {

            App\Models\Coupon::create([
                'code' => strtoupper($this->generateRandomChars(15)),
                'tax' => rand(10, 80),
            ]);
        }
    }
}
