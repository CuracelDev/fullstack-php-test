<?php

namespace App\Actions;

use App\Enums\BatchCriteria;
use App\Facades\BatchFacade;
use App\Models\Order;
use App\Notifications\CreateNewOrderNotification;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrder
{
    use AsAction;

    public function handle(Order $order)
    {
        // send mail and handle other asynchronous related task
        if ($order->hmo->batch_identified_by === BatchCriteria::SUBMISSION_DATE->value) {
            BatchFacade::createOrUpdate($order);
        } else {
            BatchFacade::createByEncounterDate($order);
        }

        $order->hmo->notify(new CreateNewOrderNotification($order));
    }
}
