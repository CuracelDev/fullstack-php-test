<?php

namespace App\Console\Commands;

use App\Actions\ProcessBatchedOrdersAction;
use App\Enums\BatchStatusEnum;
use App\Models\Batch;
use Illuminate\Console\Command;

class ProcessBatchOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curacel:process-batched-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This processes batched orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        Batch::query()
            ->with(['hmo', 'order'])
            ->where('status', BatchStatusEnum::PENDING()->value)
            ->chunkById(100, function ($batches) {
            foreach ($batches as $batch) {
               ProcessBatchedOrdersAction::run($batch);
            }
        });

        $this->info('Batch processed successfully');
        return 0;
    }
}
