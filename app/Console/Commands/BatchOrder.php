<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Batches\JobController as Batch;


class BatchOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:order';
    protected $batch;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batch All the Orders for Hmo for a given month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Batch $batch)
    {
        parent::__construct();
        $this->batch = $batch;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->batch->batchOrders();
        $this->info('Batch generation worker in process.');
        return;
    }
}
