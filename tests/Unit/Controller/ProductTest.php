<?php

namespace Tests\Unit\Controller;
use App\Http\Repositories\ProductRepository;
use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected $product;

    public function setUp(): void {
        parent::setUp();
        $this->product = app()->make(ProductRepository::class);
    }

    public function testAddProduct() {
        $data = factory(Product::class)->create();
        $this->post('/api/v1/products/add', $data->toArray())
            ->assertStatus(201);
    }

    public function testListProducts() {
        $data = factory(Product::class)->create();
        $products = $this->product->products();
        $this->assertEquals($data->name, $products[0]->name);
        }

    public function testGetProduct() {
        $data = factory(Product::class)->create();
        $product = $this->product->getProduct($data->id);
        $this->assertEquals($data->name, $product->name);
    }
    
}
