<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Models\Batch;
use App\Models\Hmo;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BatchService
{
    public static function getBatchingRules(): array
    {
        return ['encounter_month', 'month_filed'];
    }

    /**
     * Push an order to the appropriate batch
     * @throws ClientErrorException
     */
    public function batchOrder(Order $order, Hmo $hmo): void
    {
        try {
            DB::beginTransaction();

            $batchIdentifier = $this->computeBatchIdentifier($order, $hmo);

            $batch = Batch::where('identifier', $batchIdentifier)->first();

            if ($batch) {
                $batch->increment('total_amount', $order->total_amount);
            } else {
                $batch = Batch::create(
                    [
                        'identifier' => $batchIdentifier,
                        'total_amount' => $order->total_amount,
                        'reference' => generateReference(),
                        'hmo_id' => $hmo->id
                    ]
                );
            }

            $batch->orders()->attach($order->id);

            DB::commit();

            // Log info about the successful batch operation
            Log::info("Order with reference {$order->reference} was batched. Batch Reference: {$batch->reference}, Identifier: {$batch->identifier}");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error while batching order with reference {$order->reference}: " . $e->getMessage());
            throw new ClientErrorException("Error while batching order");
        }
    }

    /**
     * Compute batch identifier for incoming order
     * @throws ClientErrorException
     */
    private function computeBatchIdentifier($order, $hmo):string
    {
        return match ($hmo->batching_rule) {
            'encounter_month' => $order->provider_name . " ". date('M Y', strtotime($order->encounter_date)),
            'month_filed' => $order->provider_name . " ". date('M Y', strtotime($order->created_at)),
            default => throw new ClientErrorException("Invalid batching rule encountered: {$hmo->batching_rule}")
        };
    }
}
