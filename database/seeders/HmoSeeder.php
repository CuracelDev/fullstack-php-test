<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Hmo;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name'=>'HMO A', 'code'=> 'HMO-A', 'email'=> 'hmoa@site.com'],
        ['name'=>'HMO B', 'code'=> 'HMO-B', 'email'=> 'hmob@site.com'],
        ['name'=>'HMO C', 'code'=> 'HMO-C', 'email'=> 'hmoc@site.com'],
        ['name'=>'HMO D', 'code'=> 'HMO-D', 'email'=> 'hmod@site.com'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->hmos as $hmo) {
            Hmo::firstOrCreate($hmo);
        }
    }
}
