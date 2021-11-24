<?php

namespace App\Services;

use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Bus\Batch;
use App\Jobs\ProcessOrder;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class BatchOrders
{    
    public function __invoke()
    {
        $jobsBatch = [];
        
        $hmos = Hmo::with(['providers' => function($query){
            $query->whereHas('orders', function($query){
                $query->where('processed', false);
            });
        }])->get();

        foreach($hmos as $hmo){
            $hmo->load(['providers.orders' => function($query) use ($hmo){
                return $query->where('hmo_id', $hmo->id)
                    ->where('processed', false);
            }]);

            foreach($hmo->providers as $provider){
                
                foreach($provider->orders as $order){

                    if($this->wantsBatchesByEncounterDate($hmo) 
                        && $this->wasEncounteredLastMonth($order))
                    {
                        $jobsBatch[] = new ProcessOrder($order);
                    }
                    
                    else if($this->wantsBatchesByOrderDate($hmo) 
                        && $this->wasOrderedLastMonth($order))
                    {
                        $jobsBatch[] = new ProcessOrder($order);
                    }
                }

                if(count($jobsBatch) > 0){
                    $batch = Bus::batch($jobsBatch)->then(function (Batch $batch) use ($hmo) {
                        // All jobs completed successfully, notify hmo
                        dispatch(new \App\Jobs\NotifyHmoOfOrderCompletion($hmo))->onQueue('emails');
                    })->catch(function (Batch $batch, Throwable $e) {
                        // First batch job failure detected...
                        Log::error($e->getMessage());
                        
                    })
                    ->name($provider->name . ' ' . now()->subMonth()->format('F Y'))
                    ->onQueue('processing')
                    ->dispatch();

                    $jobsBatch = [];
                }

            }
        }
    }

    private function wantsBatchesByEncounterDate(Hmo $hmo)
    {
        return $hmo->batch_preference == 'encounter_date';
    }

    private function wasEncounteredLastMonth(Order $order)
    {
        return $order->encounter_date->month == now()->month - 1;
    }

    private function wantsBatchesByOrderDate(Hmo $hmo)
    {
        return $hmo->batch_preference == 'date_created';
    }

    private function wasOrderedLastMonth(Order $order)
    {
        return $order->created_at->month == now()->month - 1;
    }

}