<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Order;
use App\Models\Provider;
use App\Models\Hmo;


class LoadController extends ApiController
{

    public function index()
    {
        $orders = $this->getListByColumnPaginate( 'deleted_at', null, "*", new Order());
        return $this->showAll($orders);
    }

    public function store(Request $request)
    {
        $rules = [
            'provider_name' => 'required|exists:providers,name',
            'encounter_date' => 'required|date',
            'items' => 'required|array',
        ];

        $this->validate($request, $rules);
        $data = $request->all();
        $data['provider_id'] = $this->getSingleQueryByColumn('name', $data['provider_name'], "id", new Provider());
        $this->basicInsert(new Order(), $data);

        return $this->successResponse($data, 200, 'Order successfully added');
    }

}