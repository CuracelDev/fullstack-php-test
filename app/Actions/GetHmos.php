<?php
namespace App\Actions;

use App\Http\Resources\HmoResource;
use App\Models\Hmo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\Concerns\AsAction;

class GetHmos
{
    use AsAction;

    public function handle(): Collection
    {
        return Hmo::all();
    }

    public function asController(Request $request): Collection
    {
        return $this->handle();
    }

    public function jsonResponse(Collection $hmos): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return  HmoResource::collection($hmos);
    }

    public static function routes(Router $router)
    {
        $router->get('/hmos', static::class)->name("hmo.list");
    }

}
