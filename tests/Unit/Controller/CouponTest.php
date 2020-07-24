<?php

namespace Tests\Unit\Controller;
use App\Models\Coupon;
use Tests\TestCase;

class CouponTest extends TestCase
{
    protected $coupon;

    public function setUp(): void {
        parent::setUp();
    }

    public function testCreateCoupon() {
        $data = factory(Coupon::class)->create();

        $this->post('/api/v1/coupons/add', $data->toArray())
            ->assertStatus(201);
    }

    public function testListCoupons() {
        $this->get('/api/v1/coupons')
            ->assertStatus(200);
    }

    
}
