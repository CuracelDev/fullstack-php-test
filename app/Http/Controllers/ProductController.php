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
        $products = $this->product->products();
        return $this->success($products);
    }

    public function getProduct($productId) {
        $product = $this->product->getProduct($productId);
        return $this->success($product);
    }

    public function add(Request $request) {
        $product = $this->product->add($request);
        return $product;
    }
}
