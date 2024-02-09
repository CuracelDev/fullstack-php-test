<?php

namespace App\Actions\Hmo;

use App\Actions\BaseAction;
use App\Models\Hmo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\LazyCollection;

class GetHmos extends BaseAction
{
    public function handle(): LazyCollection
    {
        return Hmo::query()->select(['id', 'code'])->cursor();
    }

    public function asController(): Response|JsonResponse
    {
        return $this->success(__('Hmos fetched successfully'), $this->handle());
    }
}
