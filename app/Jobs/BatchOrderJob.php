<?php

namespace App\Jobs;

use App\Models\Hmo;
use App\Models\Order;
use App\Services\BatchService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BatchOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private Order $order;
    private Hmo $hmo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order  $order, Hmo $hmo)
    {
        $this->order = $order;
        $this->hmo = $hmo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(BatchService $batchService)
    {
        $batchService->batchOrder($this->order, $this->hmo);
    }
}
