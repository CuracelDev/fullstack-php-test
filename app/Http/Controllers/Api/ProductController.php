<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductShowResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return ProductIndexResource::collection(Product::all());
    }

    public function show($id)
    {
        return new ProductShowResource(Product::findOrFail($id));
    }
}
