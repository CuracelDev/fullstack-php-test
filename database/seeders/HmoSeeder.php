<?php

namespace Database\Seeders;

use App\Models\Hmo;
use Illuminate\Database\Seeder;

class HmoSeeder extends Seeder
{
    private $hmos = [
        ['name'=>'HMO A', 'code'=> 'HMO-A', 'email'=> 'hmo-a@example.com'],
        ['name'=>'HMO B', 'code'=> 'HMO-B', 'email'=> 'hmo-b@example.com'],
        ['name'=>'HMO C', 'code'=> 'HMO-C', 'email'=> 'hmo-c@example.com'],
        ['name'=>'HMO D', 'code'=> 'HMO-D', 'email'=> 'hmo-d@example.com'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->hmos)->each(function($hmo) {
            Hmo::updateOrCreate($hmo);
        });
    }
}
