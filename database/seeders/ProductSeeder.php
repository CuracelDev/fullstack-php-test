<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private $products = [
        [
            'name' => 'product 1',
            'amount' => 120000,
            'old_amount' => 150000,
            'age_limit' => 35,
            'purchase_frequency' => 1,
            'time_limit' => 1,
            'duration' => 'Year',
            'quantity' => 10,
        ],

        [
            'name' => 'product 2',
            'amount' => 12000,
            'old_amount' => 15000,
            'age_limit' => 20,
            'purchase_frequency' => 1,
            'time_limit' => 3,
            'duration' => 'Months',
            'quantity' => 5,
        ],

        [
            'name' => 'product 3',
            'amount' => 1000,
            'old_amount' => 5000,
            'quantity' => 2,
        ],

        [
            'name' => 'product 4',
            'amount' => 5000,
            'old_amount' => 7000,
            'quantity' => 0,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = $this->products;
        foreach ($products as $product) {
            if (!Product::where('name', $product['name'])->exists()) {
                $product['img_url'] = url('images/product.jpg');
                Product::create($product);
            }
        }
    }
}
