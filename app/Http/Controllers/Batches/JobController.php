<?php

namespace App\Http\Controllers\Batches;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Batch;
use App\Models\Order;
use App\Models\Hmo;
use App\Models\Provider;
use App\Notifications\NotifyHmo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;



class JobController extends ApiController
{

    public function __construct(Order $order, Provider $provider, Batch $batch, Hmo $hmo) 
    {
        $this->order = $order;
        $this->provider = $provider;
        $this->hmo = $hmo;
        $this->batch = $batch;
    }

    public function batchOrders()
    {
        $hmos = Hmo::all();
        foreach ($hmos as $hmo) {
            $providers = $hmo->providers();
            foreach ($providers->get() as $provider) {
                $title =  'Monthly Batch Order';
                $this->processBatch($provider, $hmo->batch_rule  == 'request_date' ? 'created_at' : $hmo->batch_rule);
                Notification::send($hmo,  new NotifyHmo(['month' => Carbon::parse(now())->format('M Y'), 'hmo' => $hmo, 'title' => $title]));
            }
        }

    }


    public function processBatch($provider, $hmoChoice)
    {
        $all = [];
        $orders = $this->order->where('provider_id', $provider->id)
            ->where('processed', false)
            ->whereMonth($hmoChoice, Carbon::now())
            ->select('id')
            ->get()
            ->toArray();

        foreach ($orders as $order) {
            $all[] = $order['id'];
        }

        $batchTitle = $hmoChoice == 'encounter_date' ? $this->getBatchNameByEncounterDate($provider) : $this->getBatchNameByRequestDate($provider);
        Batch::create([
            'orders' => json_encode($all),
            'month' => Carbon::parse(now())->format('M Y'),
            'name' => $batchTitle,
            'rule' => $hmoChoice == 'encounter_date' ? $hmoChoice : 'request_date',
            'provider_id' => $provider->id,
        ]);

        //Update Order
        $this->order->where('provider_id', $provider->id)
            ->whereMonth($hmoChoice, Carbon::now())
            ->update('processed', true);

        return true;

    }
}