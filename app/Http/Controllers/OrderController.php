<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Hmo;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderAlert;
use App\Jobs\ProcessOrder;
use Carbon\Carbon;

class OrderController extends Controller {

    public function create(Request $request)
    {
	$request->validate([
	    'items' => 'required',
	    'provider_name' => 'required', 
	    'hmo_code' => 'required',
	    'encounter_date' => 'required'
	]);
	$items = $request->input("items");
	$total = array_reduce($items, fn($total, $item) => $total + $item["quantity"] * $item["unit_price"], 0);
	$order = new Order();
	$order->provider_name = $request->input("provider_name");
	$order->hmo_code = $request->input("hmo_code");
	$order->encounter_date = $request->input("encounter_date");
	$order->items = $items;
	$order->save();
	$hmo = Hmo::where("code", $order->hmo_code)->first();
	try {
	    Mail::to($hmo)->send(new OrderAlert($total, $hmo->name, $order->provider_name));
	} catch (\ErrorException | \Swift_TransportException $ex) {
	    // unfortunate. just do other things.
	}
	$batchTime = $hmo->batch_by == "submit_date" ? Carbon::now() : Carbon::parse($order->encounter_date);
	ProcessOrder::dispatch($order)->onQueue("$hmo->name $batchTime->shortMonthName $batchTime->year");
	return response()->json($order);
    }

}
