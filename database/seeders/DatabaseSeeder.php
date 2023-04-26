<?php
namespace Database\Seeders;

use App\Models\Batch;
use App\Models\User;
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
        User::truncate();
        User::factory()->create();
        // $this->call(UserSeeder::class);
         $this->call(HmoSeeder::class);
         Batch::factory(8)->create();
    }
}
