<?php

namespace Database\Seeders;

use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::insert([
            ['product_title'=> "Poundo", 'description'=>"It is poundo", 'price'=>'25.00', 'coupon_enabled' => 1, 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()],
            ['product_title'=> "Pistol", 'description'=>"It is a gun", 'price'=>'30.00', 'coupon_enabled' => 0, 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()], 
            ['product_title'=> "Knife", 'description'=>"It is a knife", 'price'=>'15.00', 'coupon_enabled' => 1, 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()],
            ['product_title'=> "Padlock", 'description'=>"It is a padlock", 'price'=>'10.00','coupon_enabled' => 0, 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()],
        ]);
    }
}