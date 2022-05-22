<?php

namespace App\Http\Controllers\Batches;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Batch;
use App\Models\Order;
use App\Models\Hmo;
use App\Models\Provider;


class JobController extends ApiController
{

    public function batchOrders()
    {
        //get all orders for that month
        //determine criteria of hmos
        //get the batching based on the hmo criteria
        //save batches 
        //dispatch email notification to hmo
    }
}