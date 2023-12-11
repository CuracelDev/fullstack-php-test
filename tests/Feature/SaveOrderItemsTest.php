<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->hmo = \App\Models\Hmo::factory()->create();
});

it('validates request', function () {
    $result = $this->postJson(route('order-items.submit'), [])
        ->assertStatus(422)
        ->json();

    expect($result)
        ->toBeArray()
        ->message->toBeString()->toBe('The given data was invalid.')
        ->errors->toBeArray();

});

it('checks for invalid  selected hmo', function () {

    tap($this->hmo)->update(['code' => 'HMO-A']);

    $result = $this->postJson(route('order-items.submit'), [
        'hmo' => 'hmo-F'
    ])
        ->assertStatus(422)
        ->json();

    expect($result)
        ->toBeArray()
        ->message->toBeString()->toBe('The given data was invalid.')
        ->errors->toBeArray()
        ->and($result['errors'])
        ->hmo->toBeArray()
        ->and($result['errors']['hmo'][0])
        ->toBeString()->toBe('The selected hmo is invalid.');

});

test('it successfully submit order request', function () {
    tap($this->hmo)->update(['code' => 'HMO-A']);

    $result = $this->postJson(route('order-items.submit'), testData())
        ->assertStatus(200)
        ->json();

    expect($result)
        ->toBeArray()
        ->message->toBeString()->toBe('Order items submitted successfully');

});



