<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $req)
    {
         $input = $req->validate([
            "hmo_code" => "required|string",
            "name" => "required|string",
            "date" => "required|date",
            "items" => "required",
            "items.*.name" => "required|string|distinct:ignore_case",
            "items.*.unit_price" => "required|numeric",
            "items.*.quantity" => "required|numeric",
         ]);

        return response()->json([
            "message" => "Order successfully created.",
        ]);
    }
}
