<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User as Provider;
use App\Models\Hmo;
use App\Models\Order;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_item_name_is_required()
    {
        $items1 = [
            [
                //'name'=> '',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=> 5 * 2
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-5-30',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The items.0.name field is required.']);
    }

    public function test_item_quantity_is_required()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                //'quantity'=>2,
                'subTotal'=> 0
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-4-30',
            'total'=> 1
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The items.0.qty field is required.']);
    }

    public function test_item_unit_price_is_required()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                //'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=> 5 * 2
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-4-30',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The items.0.unitPrice field is required.']);
    }

    public function test_item_sub_total_is_required()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                //'subTotal'=> 5 * 2
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-4-30',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The items.0.subTotal field is required.']);
    }

    public function test_item_sub_total_cannot_be_zero()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>0
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-4-30',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The items.0.subTotal must be at least 1.']);
    }

    public function test_total_cannot_be_zero()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>0
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-4-30',
            'total'=> 0
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The total must be at least 1.']);
    }

    public function test_encounter_date_is_required()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>0
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            //'encounter_date'=> '2022-4-30',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The encounter date field is required.']);
    }

    public function test_encounter_date_is_a_date()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>0
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> 'abc',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The encounter date is not a valid date.']);
    }

    public function test_provider_id_is_required()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>0
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            //'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> 'abc',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The provider id field is required.']);
    }

    public function test_provider_id_exists()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>0
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>234, 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> 'abc',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The selected provider id is invalid.']);
    }

    public function test_hmo_id_is_required()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>0
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            //'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> 'abc',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The hmo id field is required.']);
    }

    public function test_hmo_id_is_valid()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>0
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>345,
            'items'=> $items1,
            'encounter_date'=> 'abc',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(422);
        $response->assertJson(['message'=>'The selected hmo id is invalid.']);
    }

    public function test_create_order()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>10
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-4-30',
            'total'=> 10
        ];

        $response = $this->postJson('/api/orders',$data);

        $response->assertStatus(200);
    }

    public function test_fetch_all()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>0
            ],
        ];

        $providers = Provider::factory()->count(4)->create()->toArray();
        $hmos = Hmo::factory()->count(4)->create()->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            //'encounter_date'=> '2022-4-30',
            'total'=> 10
        ];

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200);
    }

    public function test_batch_by_encounter_date()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>10
            ],
        ];

        $items2 = [
            [
                'name'=> 'itemA2',
                'unitPrice'=>3,
                'qty'=>2,
                'subTotal'=>6
            ],
        ];

        $providers = Provider::factory()->count(1)->create()->toArray();
        $hmos = Hmo::factory()->count(1)->create(['batch_type'=>'encounter_date'])->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-4-30',
            'total'=> 10
        ];
        $data1 = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-4-22',
            'total'=> 10
        ];

        $response1 = $this->postJson('/api/orders',$data);
        $response2 = $this->postJson('/api/orders',$data1);

        $response = $this->getJson("/api/hmos/{$hmos[0]['id']}/batch-orders");

        $response->assertStatus(200);

        //dd($response);

        //$response->assertJsonFragment(['2022-04'=>[ ['encounter_date' => '2022-04-22'] ] ]);
        $response->assertJsonStructure(['2022-04'=>[ ['encounter_date','items','sent_date'] ] ]);

    }

    public function test_batch_by_sent_date()
    {
        $items1 = [
            [
                'name'=> 'itemA1',
                'unitPrice'=>5,
                'qty'=>2,
                'subTotal'=>10
            ],
        ];

        $items2 = [
            [
                'name'=> 'itemA2',
                'unitPrice'=>3,
                'qty'=>2,
                'subTotal'=>6
            ],
        ];

        $providers = Provider::factory()->count(1)->create()->toArray();
        $hmos = Hmo::factory()->count(1)->create(['batch_type'=>'created_at'])->toArray();

        $data = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-4-30',
            'created_at'=> '2022-5-30',
            'total'=> 10
        ];
        $data1 = [
            'provider_id'=>$providers[0]['id'], 
            'hmo_id'=>$hmos[0]['id'],
            'items'=> $items1,
            'encounter_date'=> '2022-6-22',
            'created_at'=> '2022-4-22',
            'total'=> 10
        ];

        $response1 = $this->postJson('/api/orders',$data);
        $response2 = $this->postJson('/api/orders',$data1);

        $response = $this->getJson("/api/hmos/{$hmos[0]['id']}/batch-orders");

        $response->assertStatus(200);

        $response->assertJsonStructure(['2022-05'=>[ ['encounter_date','items','sent_date'] ],
        '2022-04'=>[ ['encounter_date','items','sent_date'] ] ]);

    }
}
