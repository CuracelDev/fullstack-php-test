<?php

namespace App\Jobs;

use App\Enums\OrderStatus;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessOrders implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currentMonth = Carbon::now()->format('F Y');

        DB::transaction(function () use ($currentMonth) {
            $orders = Order::where('status', OrderStatus::PENDING->value)
                ->whereHas('batch', function ($query) use ($currentMonth) {
                    $query->where('month', $currentMonth);
                })
                ->cursor();

            foreach ($orders as $order) {
                $order->update(['status' => OrderStatus::PROCESSING->value]);

                //Whatever condition for processing might be goes here 🤝

                $order->update(['status' => OrderStatus::COMPLETED->value]);
            }
        });
    }
}
