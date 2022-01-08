<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->email = 'aremutola@gmail.com';
        $user->password = bcrypt('aremutola');
        $user->tax_enabled = 1;
        $user->tax_percent = 10;
        $user->save();
    }
}
