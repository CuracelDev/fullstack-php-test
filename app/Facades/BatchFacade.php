<?php

namespace App\Facades;

use App\Enums\BatchCriteria;
use App\Models\Batch;
use App\Models\Order;
use App\Services\BatchService;
use Illuminate\Support\Facades\Facade;


/**
 *
 * @method static Batch createByEncounterDate(Order $order)
 * @method static Batch createOrUpdate(Order $order, BatchCriteria $criteria = BatchCriteria::SUBMISSION_DATE)
 *
 * @see BatchService
 */
class BatchFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BatchService::class;
    }
}
