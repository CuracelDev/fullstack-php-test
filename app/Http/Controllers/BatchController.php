<?php

namespace App\Http\Controllers;

use App\Http\Resources\BatchResource;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
     * @param $string 
     * 
     * @return \Illuminate\Http\Response
     */
    public function batchByEncounterDate()
    {
        return $this->_batchOrders('encounter_date');
    }

    /**
     * This will batch using the date encounter was sent
     *
     * @param $string 
     * 
     * @return \Illuminate\Http\Response
     */
    public function batchBySentDate()
    {
        return $this->_batchOrders('created_at');
    }

    /**
     * Batch orders based on the specified date format
     *
     * @param $dateFormat 
     * 
     * @return \Illuminate\Http\Response
     */
    private function _batchOrders($dateFormat)
    {
        $results = [];

        $batches = Batch::orderBy($dateFormat, 'ASC')->get();
        foreach ($batches as $batch) {
            $provider = $batch->hmo->name;
            $date = Carbon::parse($dateFormat == 'encounter_date' ? $batch->encounter_date : $batch->created_at)->format('M Y');
            $provider .= " " . $date;
            $results[] = $provider;
        }
        return BatchResource::collection([$results]);
    }

}
