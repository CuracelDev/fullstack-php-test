<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    // get all products
    public function index()
    {
        $product = Products::get();

        return response($product, Response::HTTP_OK);
    }
}
