<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 100; $i++) {
            App\Models\User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'age' => rand(10, 100),
                'tax' => rand(2, 10),
                'password' => Hash::make('password'),
            ]);
        }
    }
}
