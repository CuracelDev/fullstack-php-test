<?php

namespace App\Http\Controllers;

use App\Models\Hmo;
use App\Models\Batch;
use App\Mail\OrderMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\BatchResource;

class BatchController extends Controller
{
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
            'encounter_date' => $data['encounterDate']
        ];
    }

    /**
     * This will batch using month of encounter
     *
     * @param Hmo $hmo 
     * 
     * @return \Illuminate\Http\Response
     */
    public function batchByEncounterDate(Hmo $hmo)
    {
        return $this->_batchOrders('encounter_date', $hmo);
    }

    /**
     * This will batch using the date encounter was sent
     *
     * @param Hmo $hmo 
     * 
     * @return \Illuminate\Http\Response
     */
    public function batchBySentDate(Hmo $hmo)
    {
        return $this->_batchOrders('created_at', $hmo);
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

        $batches = Batch::orderBy($dateFormat, 'ASC')->get();
        foreach ($batches as $batch) {
            $provider = $batch->hmo->name;
            $date = Carbon::parse($dateFormat == 'encounter_date' ? $batch->encounter_date : $batch->created_at)->format('M Y');
            $provider .= " " . $date;
            $results[] = $provider;
        }
        Mail::to($hmo)->send(new OrderMail($hmo));
        return BatchResource::collection([$results]);
    }

}
