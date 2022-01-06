<?php

namespace App\Services;

use Throwable;
use App\Models\Hmo;
use App\Jobs\NotifyHMO;
use Illuminate\Bus\Batch;
use App\Jobs\ProcessOrder;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class OrderBatch
{
    /**
     * Call when the OrderBatch is called
     * 
     * @return array
     */
    public function __invoke()
    {
        $jobsBatch = [];

        $hmos = Hmo::with(
            [
                'providers' => function ($query) {
                    $query->whereHas('orders');
                }
            ]
        )->get();

        foreach ($hmos as $hmo) {
            $hmo->load(
                ['providers.orders' => function ($query) use ($hmo) {
                    return $query->where('hmo_id', $hmo->id);
                }
                ]
            );

            foreach ($hmo->providers as $provider) {

                foreach ($provider->orders as $order) {

                    if ($this->_wantsEncounterDate($hmo)) {
                        $jobsBatch[] = new ProcessOrder($order);
                    } elseif ($this->_wantsOrderDate($hmo)) {
                        $jobsBatch[] = new ProcessOrder($order);
                    }
                }

                if (count($jobsBatch) > 0) {
                    Bus::batch($jobsBatch)
                        ->then(
                            function () use ($hmo) {
                                dispatch(new NotifyHMO($hmo))
                                    ->onQueue('emails');
                            }
                        )
                    ->catch(
                        function (Throwable $e) { 
                            Log::error($e->getMessage()); 
                        }
                    )
                        ->name($provider->name . ' ' . now()->subMonth()->format('F Y'))
                        ->onQueue('processing')
                        ->dispatch();

                    $jobsBatch = [];
                }
            }
        }
    }

    /**
     * This function check for the encounter HMO
     * 
     * @param App\Models\Hmo $hmo 
     * 
     * @return boolean
     */
    private function _wantsEncounterDate(Hmo $hmo)
    {
        return $hmo->batch_pref == 'encounter_date';
    }

    /**
     * This function check for the Date created HMO
     * 
     * @param App\Models\Hmo $hmo 
     * 
     * @return boolean
     */
    private function _wantsOrderDate(Hmo $hmo)
    {
        return $hmo->batch_pref == 'date_created';
    }
}
