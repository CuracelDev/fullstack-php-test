<?php

namespace App\Actions;

use App\DTOs\Models\HMOData;
use App\DTOs\Requests\SaveOrderItems\SaveOrderItemsData;
use App\DTOs\Responses\ApiResponseSuccess;
use App\Enums\BatchRequirementEnum;
use App\Enums\BatchStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Requests\SaveOrderItemRequest;
use App\Mail\OrderStatusMail;
use App\Models\Batch;
use App\Models\Hmo;
use App\Models\Order;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class SaveOrderItemsAction
{
    use AsAction;

    public function handle(SaveOrderItemsData $savedOrderItemsData): void
    {

        $hmo = Hmo::query()
            ->where('code', $savedOrderItemsData->hmo)
            ->first();

        ProcessOrderAction::run($savedOrderItemsData, $hmo);


    }

    public function asController(SaveOrderItemRequest $request)
    {
        $this->handle(
            new SaveOrderItemsData($request->validated())
        );

        return ApiResponseSuccess::make(
            'Order items submitted successfully'
        );
    }



}
