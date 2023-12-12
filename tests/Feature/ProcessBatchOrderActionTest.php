<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->hmo = \App\Models\Hmo::factory()->create();
});


test('it updates order status to processed', function () {
    $saveOrderItemsData = new \App\DTOs\Requests\SaveOrderItems\SaveOrderItemsData(testData());

    \App\Actions\ProcessOrderAction::run($saveOrderItemsData, $this->hmo);

    $batch = \App\Models\Batch::query()
        ->where('hmo_id', $this->hmo->id)
        ->first();

    \App\Actions\ProcessBatchedOrdersAction::run($batch);

    $batch->refresh();


    $order = \App\Models\Order::query()
        ->where('hmo_id', $this->hmo->id)
        ->first();

    expect($order)
        ->status->toBeString()->toBe(\App\Enums\OrderStatusEnum::PROCESSED()->value);
});


test('it updates batch status to processed', function () {
    $saveOrderItemsData = new \App\DTOs\Requests\SaveOrderItems\SaveOrderItemsData(testData());

    \App\Actions\ProcessOrderAction::run($saveOrderItemsData, $this->hmo);

    $batch = \App\Models\Batch::query()
        ->where('hmo_id', $this->hmo->id)
        ->first();

    \App\Actions\ProcessBatchedOrdersAction::run($batch);

    $batch->refresh();


    $order = \App\Models\Order::query()
        ->where('hmo_id', $this->hmo->id)
        ->first();

    expect($batch)
        ->status->toBeString()->toBe(\App\Enums\BatchStatusEnum::PROCESSED()->value);
});
