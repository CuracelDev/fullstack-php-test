<?php

namespace App\Actions;

use App\DTOs\Responses\ApiResponseSuccess;
use App\Models\Hmo;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsController;

class FetchAvailableHMOsAction
{
    use AsAction;

    public function handle(): array
    {
       return Hmo::query()->get()->toArray();

    }

    public function asController(Request $request)
    {
        $data = $this->handle();

        return ApiResponseSuccess::make(
            'Hmos fetched successfully',
            $data
        );
    }
}
