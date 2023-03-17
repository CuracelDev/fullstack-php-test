<?php

namespace App\Http\Controllers;

use App\Models\Order;
use DateTime;
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

         Order::create([
            "provider_name" => $input["name"],
            "hmo_code" => $input["hmo_code"],
            "items" => $input["items"],
            "date" => new DateTime($input["date"]),
         ]);

        return response()->json([
            "message" => "Order successfully created.",
        ]);
    }
}
