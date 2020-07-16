<?php

namespace App\Http\Repositories;
use App\Http\CommonHelper;
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

    public function products() {
    
    }

    public function add($data) {
        
    }
}
