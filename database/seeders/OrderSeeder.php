<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\Hmo;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{

    function __construct()
    {
        $this->providers = User::factory()->count(4)->create()->toArray();
        $this->hmos = Hmo::factory()->count(4)->create()->toArray();
        
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'price'=>5,
                'qty'=>2,
                'subTotal'=> 5 * 2
            ],
            [
                'name'=> 'itemA2',
                'price'=>3,
                'qity'=>2,
                'subTotal'=> 3 * 2
            ]
        ];

        $items2 = [
            [
                'name'=> 'itemB1',
                'price'=>5,
                'qty'=>2,
                'subTotal'=> 5 * 2
            ],
            [
                'name'=> 'itemB2',
                'price'=>3,
                'qty'=>2,
                'subTotal'=> 3 * 2
            ]
        ];

        $this->orders = [
            [
                'provider_id'=>$this->providers[0]['id'], 
                'hmo_id'=>$this->hmos[0]['id'],
                'items'=> json_encode($items1),
                'encounter_date'=> now()->addWeek(),
                'total'=> array_sum(array_column($items1,'subTotal')),
                'created_at'=>now()
            ],
            [
                'provider_id'=>$this->providers[1]['id'], 
                'hmo_id'=>$this->hmos[1]['id'],
                'items'=>json_encode($items2),
                'encounter_date'=> now()->addWeek(),
                'total'=> array_sum(array_column($items2,'subTotal')),
                'created_at'=>now()
            ]
        ];

        DB::table('orders')->insert($this->orders);

    }
}
