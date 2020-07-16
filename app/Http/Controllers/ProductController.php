<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Repositories\ProductRepository;

class ProductController extends Controller
{
    protected $product;

    public function __construct(
        ProductRepository $product
    ) {
        $this->product = $product;
    }

    public function products() {
        
    }

    public function add(Request $request) {
 
    }
}
