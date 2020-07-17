<?php

namespace App\Http\Repositories;
use App\Http\CommonHelper;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use DB;
use Validator;

class ProductRepository
{
    use CommonHelper;
    
    protected $product;

    public function __construct(
        Product $product
    ) {
        $this->product = $product;
    }

    public function getProduct($productId) {
        return new ProductResource($this->product->with('orders')->find($productId));
    }

    public function products() {
        $products = ProductResource::collection($this->product->orderBy('id', 'DESC')->get());
        return $products;
    }

    public function add($data) {
        
    }
}
