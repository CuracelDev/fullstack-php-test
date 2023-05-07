<?php

namespace App\Services;

use App\BatchHmoData;
use App\Mail\HmoBatchOrderMail;
use App\Models\Hmo;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderService 
{

    public function createHmoOrder(Hmo $hmo, FormRequest $request): BatchHmoData
    {
        $order = $this->createOrder($hmo, $request);
        $this->createOrderItems($order, $request);
        if ($hmo->email) Mail::to($hmo->email)->send(new HmoBatchOrderMail($order));
        return $this->batchHmoOrders($hmo);
    }

    protected function createOrder(Hmo $hmo, FormRequest $request): Order
    {
        return Order::create([
            'hmo_id' => $hmo->id,
            'encounter_date' => $request->encounter_date
        ]);
    }

    protected function createOrderItems(Order $order, FormRequest $request): Collection
    {
        return collect($request->items)->map(function (array $currentItem) use ($order) {
            return OrderItem::create([
                'order_id' => $order->id,
                'title' => $currentItem['title'],
                'unit_price' => $currentItem['unit_price'],
                'quantity' => $currentItem['quantity']
            ]);
        });
    }

    public function batchHmoOrders($hmo = null): BatchHmoData
    {
        $data = DB::table('hmos')
            ->when($hmo, function ($query, $hmo) {
                return $query->where('hmos.id', $hmo->id);   
            })
            ->join('orders', 'hmos.id', '=', 'orders.hmo_id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select(
                DB::raw('CONCAT(hmos.name, " ", DATE_FORMAT(
                    CASE
                        WHEN hmos.batch_type = "ENCOUNTER_DATE" THEN orders.encounter_date 
                        WHEN hmos.batch_type = "CREATION_DATE" THEN orders.created_at
                    END, "%b %Y")) AS hmo_group, 
                    sum(order_items.unit_price * order_items.quantity) as total_price,
                    count(distinct orders.id) as orders_count,
                    count(order_items.id) as order_items_count'
                )
            )->groupBy(
                'hmos.batch_type',
                'hmos.name', 
                DB::raw('
                    CASE 
                        WHEN hmos.batch_type = "ENCOUNTER_DATE" THEN DATE_FORMAT(orders.encounter_date, "%m %Y") 
                        WHEN hmos.batch_type = "CREATION_DATE" THEN DATE_FORMAT(orders.created_at, "%m %Y")
                    END
                ')
            )->orderBy(
                DB::raw('
                    CASE 
                        WHEN hmos.batch_type = "ENCOUNTER_DATE" THEN orders.encounter_date 
                        WHEN hmos.batch_type = "CREATION_DATE" THEN orders.created_at
                    END
                '), 'ASC'
            )->get();
        return new BatchHmoData($data);
    }
}
