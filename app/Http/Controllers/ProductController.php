<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\ManagesResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use ManagesResponse;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::with(['coupons'])->get();
        return $this->sendResponse('Products fetched', $products, 200)->setStatusCode(200);
    }
}
