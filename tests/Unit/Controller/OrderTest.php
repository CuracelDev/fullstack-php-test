<?php

namespace Tests\Unit\Controller;
use App\Http\Repositories\OrderRepository;
use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class OrderTest extends TestCase
{
    protected $order;
    
    public function setUp(): void {
        parent::setUp();
        $this->order = app()->make(OrderRepository::class);
    }

    public function authenticateUser() {
        $data = [ 
            'email' => 'ayodeleoniosun@gmail.com',
            'password' => 'password',
        ];
        
        $login = $this->post('/api/v1/login', $data);
        $token = $login['data']['token'];
        return $token;
    }

    public function testMyOrders() {
        $token = $this->authenticateUser();
        
        $this->withHeaders([
                'x-access-token' => $token
            ])
            ->get('/api/v1/orders')
            ->assertStatus(200);
    } 

    public function testAddToCart() {
        $order = factory(Order::class)->create();
        $token = $this->authenticateUser();
        
        $this->withHeaders([
                'x-access-token' => $token
            ])
            ->post('/api/v1/orders/add-to-cart')
            ->assertStatus(201);
    } 

    public function testDeleteOrder() {
        $order = factory(Order::class)->create();
        $token = $this->authenticateUser();
        
        $this->withHeaders([
                'x-access-token' => $token
            ])
            ->delete('/api/v1/orders/delete/'.$order->id)
            ->assertStatus(200);
    } 
}
