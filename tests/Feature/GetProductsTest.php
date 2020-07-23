<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function products_can_be_viewed()
    {
        $this->withoutExceptionHandling();

        $products = factory(Product::class, 2)->create();
        $response = $this->get('/api/products');

        $response->assertStatus(200)
            ->assertJson([
                "data" => [
                    [
                        'id' => $products->first()->id,
                        'name' => $products->first()->name,
                        'details' => $products->first()->details,
                        'price' => $products->first()->price,
                    ],
                    [
                        'id' => $products->last()->id,
                        'name' => $products->last()->name,
                        'details' => $products->last()->details,
                        'price' => $products->last()->price,
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function product_can_be_viewed_by_id()
    {
        $this->withoutExceptionHandling();

        $product = factory(Product::class, 1)->create();
        $response = $this->get('/api/products/' . $product->first()->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->first()->id,
                    'name' => $product->first()->name,
                    'details' => $product->first()->details,
                    'price' => $product->first()->price,
                    'coupon_needed' => $product->first()->coupon_needed,
                    'age_limit' => $product->first()->age_limit,
                    'purchase_limit' => $product->first()->purchase_limit,
                ],
            ]);
    }

}
