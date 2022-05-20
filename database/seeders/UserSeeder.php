<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{

    private $users = [
        ['name'=>'James'],
        ['name'=>'Mark'],
        ['name'=>'Blake'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('users')->insert($this->users);
        \App\Models\User::factory()->count(2)->make();
    }
}
