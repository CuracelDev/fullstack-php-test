<?php

namespace App\Http\Controllers;

use App\Models\Hmo;
use App\Models\Batch;
use App\Mail\OrderMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\BatchResource;
use App\Models\Order;

class BatchController extends Controller
{

    /**
     * Return Batch already created 
     * 
     * @param Hmo $hmo 
     * 
     * @return BatchResource
     */
    public function index(Hmo $hmo)
    {
        $results = [];
        $enc_date = 'encounter_date';

        $batches = Batch::where('hmo_id', $hmo->id)
            ->orderBy($hmo->batch_pref, 'ASC')
            ->get();
        foreach ($batches as $batch) {
            $provider = $batch->hmo->name;
            $date = Carbon::parse(
                $hmo->batch_pref == $enc_date
                    ? $batch->encounter_date : $batch->created_at
            )
                ->format('M Y');
            $provider .= " " . $date;
            $results[] = $provider;
        }

        return BatchResource::collection([$results]);
    }

    /**
     * Store batch 
     * 
     * @param $data 
     * 
     * @return string
     */
    public function store($data)
    {
        Batch::firstOrCreate($this->dataToStore($data));

        return "saved";
    }

    /**
     * Prepare data to store for batch
     * 
     * @param $data 
     * 
     * @return array
     */
    public function dataToStore($data)
    {

        return [
            'hmo_id' => $data['hmoId'],
            'order_ids' => json_encode($data['orderIds']),
            'encounter_date' => $data['encounterDate']
        ];
    }

    /**
     * This will batch using month of encounter
     *
     * @param Hmo $hmo 
     * @param $date which is the month
     * 
     * @return \Illuminate\Http\Response
     */
    public function batchByEncounterDate(Hmo $hmo, $date)
    {
        $encounterDate = 'encounter_date';
        $batchData = $this->makeBatchRecord($hmo, $date, $encounterDate);
        $this->store($batchData);

        return $this->_batchOrders($encounterDate, $hmo);
    }

    /**
     * This will batch using the date encounter was sent
     *
     * @param Hmo $hmo 
     * @param $date which is the month
     * 
     * @return \Illuminate\Http\Response
     */
    public function batchBySentDate(Hmo $hmo, $date)
    {
        $dateCreated = 'created_at';
        $batchData = $this->makeBatchRecord($hmo, $date, $dateCreated);
        $this->store($batchData);
        return $this->_batchOrders($dateCreated, $hmo);
    }

    /**
     * Batch orders based on the specified date format
     *
     * @param $dateFormat 
     * @param Hmo $hmo 
     * 
     * @return \Illuminate\Http\Response
     */
    private function _batchOrders($dateFormat, Hmo $hmo)
    {
        $results = [];
        $enc_date = 'encounter_date';

        $batches = Batch::where('hmo_id', $hmo->id)
            ->orderBy($dateFormat, 'ASC')
            ->get();
        foreach ($batches as $batch) {
            $provider = $batch->hmo->name;
            $date = Carbon::parse(
                $dateFormat == $enc_date 
                ? $batch->encounter_date : $batch->created_at
            )
                ->format('M Y');
            $provider .= " " . $date;
            $results[] = $provider;
        }
        Mail::to($hmo)->send(new OrderMail($hmo));
        return BatchResource::collection([$results]);
    }

    /**
     * Make the Batch record as needed per time
     * 
     * @param Hmo $hmo 
     * @param $date   month of the year you want
     * @param $search string between created_at and encounter_date
     * 
     * @return array
     */
    public function makeBatchRecord(Hmo $hmo, $date, $search)
    {
        $from = Carbon::parse('2022-' . $date . '-01')
            ->firstOfMonth()
            ->toDateString();
        $to = Carbon::parse('2022-' . $date . '-01')
            ->endOfMonth()
            ->toDateString();
        $orders = Order::where('hmo_id', $hmo->id)
            ->whereBetween(
                $search,
                [
                    $from, $to
                ]
            )->get();


        $getOrderId = [];
        foreach ($orders as $order) {
            $getOrderId[] = $order->id;
        }


        return [
            'hmoId' => $hmo->id,
            'orderIds' => $getOrderId,
            'encounterDate' => $from
        ];
    }

}
