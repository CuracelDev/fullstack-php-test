<?php

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddCouponTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function add_new_coupon()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class, 1)->create();
        $product = factory(Product::class, 2)->create();

        $response = $this->post('/api/coupons', [
            "code" => "BLACKFRIDAY2020",
            "discount" => 20,
            "user_id" => $user->first()->id,
            "product_id" => [$product->first()->id, $product->last()->id],
        ])->assertStatus(200);

        $coupon = Coupon::first();

        $this->assertCount(2, Coupon::all());
        $this->assertEquals("BLACKFRIDAY2020-0", $coupon->code);
        $this->assertEquals(20, $coupon->discount);

    }
}
