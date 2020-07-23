<?php

namespace Tests\Feature;

use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCouponsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function coupons_can_be_viewed()
    {
        $this->withoutExceptionHandling();

        $coupons = factory(Coupon::class, 2)->create();
        $user1 = $coupons->first()->user;
        $user2 = $coupons->last()->user;

        $response = $this->get('/api/coupons');

        $response->assertStatus(200)
            ->assertJson([
                "data" => [
                    [
                        'id' => $coupons->first()->id,
                        'code' => $coupons->first()->code,
                        'discount' => $coupons->first()->discount,
                        'user_id' => [
                            'id' => $user1->id,
                            'name' => $user1->name,
                        ],
                        'product_id' => $coupons->first()->product_id,
                    ],
                    [
                        'id' => $coupons->last()->id,
                        'code' => $coupons->last()->code,
                        'discount' => $coupons->last()->discount,
                        'user_id' => [
                            'id' => $user2->id,
                            'name' => $user2->name,
                        ],
                        'product_id' => $coupons->last()->product_id,
                    ],
                ],
            ]);
    }
}
