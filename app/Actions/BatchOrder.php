<?php
namespace App\Actions;

use App\Batchers\BatchByEncounter;
use App\Batchers\BatchByOrder;
use App\Batchers\Batcher;
use App\Constants\FulfilmentType;
use App\Constants\Status;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;
use \App\Models\Order;

class BatchOrder
{
    use AsAction;

    public string $jobConnection = 'database';
    public string $jobQueue = 'batchers';
    public int $jobTries = 1;

    /**
     * @throws \Exception
     */
    public function handle(Order $order, Batcher $batcher = null): Order
    {
        if($order->status !== Status::PENDING)
            throw new \Exception("Order is not pending");
        /**
         * @var Batcher $batcher
         */
        $batcher = $batcher ?? $this->defaultBatcher($order);
        $batch = Batch::firstOrCreate(
            [
                "name" => $batcher->batchName(),
                "to_be_processed_on" => $batcher->processOn()->format("Y-m-d")
            ],
        );
        $order->update([ "batch_id" => $batch->id, "status" => Status::QUEUED ]);
        ProcessOrder::dispatch($order)->delay($batcher->processDelay());
        return $order->refresh();
    }

    public function defaultBatcher(Order $order): Batcher
    {
        return [
            FulfilmentType::ORDER => new BatchByOrder($order),
            FulfilmentType::ENCOUNTER => new BatchByEncounter($order)
        ][$order->hmo->fulfil_by];
    }

    public function asController(Request $request, $orderId)
    {
        $order = Order::where([["id", $orderId], ["status", Status::PENDING]])->firstOrFail();
        $this->handle($order);
    }

    public function jsonResponse($result, Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(["status" => true]);
    }

    public static function routes(Router $router)
    {
        $router->post('/order/{order}/batch', static::class)->name("order.batch");
    }

}
