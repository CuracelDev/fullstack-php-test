<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name'=>'HMO A', 'code'=> 'HMO-A', 'email' => 'hmo-a@domain.com'],
        ['name'=>'HMO B', 'code'=> 'HMO-B', 'email' => 'hmo-b@domain.com'],
        ['name'=>'HMO C', 'code'=> 'HMO-C', 'email' => 'hmo-c@domain.com'],
        ['name'=>'HMO D', 'code'=> 'HMO-D', 'email' => 'hmo-d@domain.com'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hmos')->insert($this->hmos);
    }
}
