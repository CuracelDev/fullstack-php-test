<?php

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplyCouponTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_apply_coupon_to_product()
    {
        $this->withoutExceptionHandling();

        $coupons = factory(Coupon::class, 1)->create();
        $user = $coupons->first()->user;
        $product_id = $coupons->first()->product_id;
        $product = Product::findOrFail($product_id);

        $response = $this->get('/api/products/' . $product_id . '/price?coupon=' . $coupons->first()->code);

        if ($user->age < $product->age_limit) {
            $response->assertStatus(400)->assertJsonStructure([
                'message',
            ]);
        } else {
            $response->assertStatus(200)->assertJsonStructure([
                'initial_price',
                'discounted_price',
                'tax',
                'total_price',
            ]);
        }
    }
}
