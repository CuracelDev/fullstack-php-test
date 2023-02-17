<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use \App\Models\Order;
use \App\Mail\OrderAlert;
use App\Models\Hmo;
use \Carbon\Carbon;
use App\Jobs\ProcessOrder;

class OrderTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function createsOrderInDataBase()
    { // Run the DatabaseSeeder...
	$this->seed();
	$data = ['provider_name' => 'poster1', 'hmo_code' => 'HMO-A', 'encounter_date' => '2022-05-20', 'items' => [
		['name' => 'peanuts', 'unit_price' => '150', 'quantity' => 3],
		['name' => 'agbado', 'unit_price' => '250', 'quantity' => 1]
	]];
	$response = $this->post('/api/order', $data);
	$response->assertStatus(200);
	$savedData = Order::find(1);
	$response->assertExactJson($savedData->toArray(), true); // ensure what is sent back is what was saved
	$data["id"] = $response->json("id");  //attach the id and other auto-generated fields and compare input with what the server actually saved
	$data["created_at"] = $response->json("created_at");
	$data["updated_at"] = $response->json("updated_at");
	$this->assertEquals($data, $savedData->toArray());
    }

    /** @test */
    public function sendsEmailAfterCreatingOrder()
    {
	// Run the DatabaseSeeder...
	$this->seed();
	Mail::fake();
	$data = ['provider_name' => 'poster1', 'hmo_code' => 'HMO-B', 'encounter_date' => '2023-01-20', 'items' => [
		['name' => 'corn', 'unit_price' => '350', 'quantity' => 5],
		['name' => 'bala blue', 'unit_price' => '3500', 'quantity' => 12]
	]];
	$response = $this->post('/api/order', $data);
	$response->assertStatus(200);
	$hmo = Hmo::where('code', 'HMO-B')->first();
	Mail::assertSent(function (OrderAlert $alert) use ($hmo) {
	    return $alert->total == 43750 && $alert->provider_name == 'poster1' && $alert->hmo_name == $hmo->name;
	});
    }
    /** @test */
    public function queuesOrderByEncounterDateForHmosThatOptForThat()
    {
	// Run the DatabaseSeeder...
	$this->seed();
	Queue::fake();
	$data = ['provider_name' => 'poster3', 'hmo_code' => 'HMO-C', 'encounter_date' => '2023-01-20', 'items' => [ // Hmo C batches by encounter
		['name' => 'bulaba', 'unit_price' => '350', 'quantity' => 5],
		['name' => 'bala blue', 'unit_price' => '3500', 'quantity' => 12]
	]];
	$response = $this->post('/api/order', $data);
	$response->assertStatus(200);
	$hmo = Hmo::where('code', 'HMO-C')->first();
	$encounterDate = Carbon::parse('2023-01-20'); // these will be processed together
	$batchName = "$hmo->name $encounterDate->shortMonthName $encounterDate->year"; // by encounter_date
	Queue::assertPushedOn($batchName, function (ProcessOrder $job) use ($response) {
	    return $job->order->id == $response->json("id");
	});
//	Queue::assertPushed(ProcessOrder::class);
    }
    public function queuesOrderBySubmitDateForHmosThatOptForThat()
    {
	// Run the DatabaseSeeder...
	$this->seed();
	Queue::fake();
	$data = ['provider_name' => 'poster4', 'hmo_code' => 'HMO-A', 'encounter_date' => '2023-01-20', 'items' => [ // Hmo A batches by encounter
		['name' => 'bulaba', 'unit_price' => '350', 'quantity' => 5],
		['name' => 'bala blue', 'unit_price' => '3500', 'quantity' => 12]
	]];
	$response = $this->post('/api/order', $data);
	$response->assertStatus(200);
	$hmo = Hmo::where('code', 'HMO-C')->first();
	$submissionDate = Carbon::now();
	$batchName = "$hmo->name $submissionDate->shortMonthName $submissionDate->year";
	Queue::assertPushedOn($batchName, function (ProcessOrder $job) use ($response) {
	    return $job->order->id == $response->json("id");
	});
    }
}
