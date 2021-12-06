<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hmo;
use App\Models\Order;
use App\Models\Batch;
use Carbon\Carbon;
use Mail;

class OrderController extends Controller
{
    /**
    * Submit order from vue frontend
    *
    * @return \Illuminate\Http\Response
    */
    public function orderSubmit(Request $request)
    {
        $data = $request->all();

        $hmoData = [
          'code' => $data['hmo']['code'],
          'name' => $data['hmo']['name'],
        ];

        //create hmo if it does not exist
        $hmo = Hmo::firstOrCreate(
            ['code' => $hmoData['code']],
            $hmoData
        );

        //create batch
        $batchData =[
          'hmo_id'=>$hmo->id,
          'edate' => Carbon::parse($data['edate']),
        ];
        $batch = Batch::create($batchData);

        //store each order
        foreach ($data['orders'] as $order) {
            $orderData = [
          'hmo_id'=>$hmo->id,
          'batch_id'=>$batch->id,
          'items' => json_encode($order),
          ];
            $order = Order::create($orderData);
        }

        //send mail
        $mailData = [
          'name'=>$hmo->name,
          'email'=>$hmo->email,
          'subject'=>"Your order has been sent",
          'body'=> "Total orders submitted " . $data['total'],
        ];

        Mail::send('mail/order', $mailData, function ($message) use ($mailData) {
            $message->to($mailData['email'], $mailData['name'])->subject($mailData['subject']);
            $message->from('fullstack@site.com', 'FullStack Test');
        });

        return response()->json(["message"=>"Order submitted successfully"], 200);
    }

    /**
    * This will batch using month of encounter
    *
    * @return \Illuminate\Http\Response
    */
    public function batchByEncounterDate(Request $request)
    {
        return $this->batchOrders($request, 'edate');
    }

    /**
    * This will batch using the date encounter was sent
    *
    * @return \Illuminate\Http\Response
    */
    public function batchBySentDate(Request $request)
    {
        return $this->batchOrders($request, 'created_at');
    }

    /**
    * Batch orders based on the specified date format
    *
    * @return \Illuminate\Http\Response
    */
    private function batchOrders(Request $request, String $dateFormat)
    {
        $result = [];

        $batches = Batch::orderBy($dateFormat, 'ASC')->get();
        foreach ($batches as $batch) {
            $provider = $batch->hmo->name;
            $date = Carbon::parse($dateFormat=='edate' ? $batch->edate : $batch->created_at)->format('M Y');
            $provider.= " " . $date;
            $result[] = $provider;
        }
        return response()->json([$result], 200);
    }
}
