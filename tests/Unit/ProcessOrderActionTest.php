<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
   $this->hmo = \App\Models\Hmo::factory()->create();
    \Illuminate\Support\Facades\Mail::fake();
});

test('it stores process_batch_at as the encounter_date ', function (){

    $hmo = tap($this->hmo)->update(['batch_requirement' => \App\Enums\BatchRequirementEnum::ENCOUNTER_DATE()->value]);

    $saveOrderItemsData = new \App\DTOs\Requests\SaveOrderItems\SaveOrderItemsData(testData());

    \App\Actions\ProcessOrderAction::run($saveOrderItemsData, $hmo);

    $batch = \App\Models\Batch::query()
        ->where('hmo_id', $hmo->id)
        ->first();

    expect($batch)
        ->process_batch_at->toBeString()->toBe($saveOrderItemsData->encounterDate);


});

test('it stores process_batch_at as the sent_date ', function (){

    $hmo = tap($this->hmo)->update(['batch_requirement' => \App\Enums\BatchRequirementEnum::SENT_DATE()->value]);

    $saveOrderItemsData = new \App\DTOs\Requests\SaveOrderItems\SaveOrderItemsData(testData());

    \App\Actions\ProcessOrderAction::run($saveOrderItemsData, $hmo);

    $batch = \App\Models\Batch::query()
        ->where('hmo_id', $hmo->id)
        ->first();

    $order = \App\Models\Order::query()
        ->where('hmo_id', $hmo->id)
        ->first();

    expect($batch)
        ->process_batch_at->toBeString()->toBe($order->created_at->format('Y-m-j H:i:s'));


});

test('it sent a mail to the respective hmo ', function () {

    $saveOrderItemsData = new \App\DTOs\Requests\SaveOrderItems\SaveOrderItemsData(testData());


    \App\Actions\ProcessOrderAction::run($saveOrderItemsData, $this->hmo);

    \Illuminate\Support\Facades\Mail::assertSent(function (\App\Mail\BatchStatusMail $mail){
        return $mail->to[0]['address'] === $this->hmo->email;
    });

});

test('it sent a mail to the respective provider ', function () {

    $saveOrderItemsData = new \App\DTOs\Requests\SaveOrderItems\SaveOrderItemsData(testData());

    \Illuminate\Support\Facades\Mail::fake();

    \App\Actions\ProcessOrderAction::run($saveOrderItemsData, $this->hmo);

    $provider = \App\Models\Provider::query()
        ->where('name', testData()['providerName'])
        ->first();

    \Illuminate\Support\Facades\Mail::assertSent(function (\App\Mail\OrderStatusMail $mail) use ($provider){
        return $mail->to[0]['address'] === $provider->email;
    });

});
