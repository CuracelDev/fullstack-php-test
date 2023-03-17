<?php

namespace App\Http\Controllers;

use App\Models\Hmo;
use App\Models\Order;
use DateTime;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $req)
    {
        $rules = [
            "hmo_code" => "required|string|exists:hmos,code",
            "name" => "required|string",
            "date" => "required|date",
            "items" => "required",
            "items.*.name" => "required|string|distinct:ignore_case",
            "items.*.unit_price" => "required|numeric",
            "items.*.quantity" => "required|numeric",
        ];
        
        $input = $this->validate($req, $rules);

        $hmo = Hmo::where("code", $input["hmo_code"])->first();

        Order::create([
            "provider_name" => $input["name"],
            "hmo_id" => $hmo->id,
            "items" => $input["items"],
            "date" => new DateTime($input["date"]),
        ]);

        return response()->json([
            "message" => "Order successfully created.",
        ]);
    }
}
