<?php
namespace Database\Seeders;

use App\Models\Hmo;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Hmo::truncate();
        Order::truncate();
        Schema::enableForeignKeyConstraints();

        User::create([
            'name' => "Curacel Admin",
            'email' => "admin@example.com",
            'role' => 'admin',
            'password' => bcrypt('pass123')
        ]);

        User::factory(200)->hasHmos(3)->create(['role' => 'hmo']);

        User::factory(100)->create();

        Order::factory(1000)->create();
    }
}
