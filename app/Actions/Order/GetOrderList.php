<?php

namespace App\Actions\Order;

use App\Models\Order;
use Illuminate\Support\Collection;
use App\Http\Resources\OrderApiResource;
use Lorisleiva\Actions\Concerns\AsAction;

class GetOrderList
{
    use AsAction;

    /**
     * Retrieves a list of orders based on the provided filter query.
     *
     * @param  array  $filterQuery
     * @return Collection
     */
    public function handle(array $filterQuery): Collection
    {
        $orders = Order::with('hmo')->filterBy($filterQuery)->get();

        return $this->formatOrders($orders);
    }

    /**
     * Formats the orders for API response.
     *
     * @param  Collection  $orders
     * @return Collection
     */
    private function formatOrders(Collection $orders): Collection
    {
        return $orders->groupBy('user_month_year')->map(function ($groupedOrders) {
            return $groupedOrders->map(function ($order) {
                return new OrderApiResource($order);
            });
        });
    }
}
