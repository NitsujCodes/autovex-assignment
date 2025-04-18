<?php

namespace Tests\Feature\Api\V1\Cart;

use App\Http\Resources\V1\ProductResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Services\CartServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_endpoint_add_product_to_cart() : void
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
        ]);

        $products = Product::factory()->count(50)->create();
        $cartProducts = $products->random(rand(1, 5));

        foreach ($cartProducts as $product) {
            $qty = rand(1, 5);
            $response = $this->postJson("/api/v1/cart/{$cart->id}/product", [
                'product_id' => $product->id,
                'quantity' => $qty,
            ]);

            $response->assertStatus(200);
            $this->assertValidJsonDataResponse($response);

            // Check for product match
            $response->assertJsonPath('data.id', $product->getKey());
            $response->assertJsonPath('data.sku', $product->sku);
            $response->assertJsonPath('data.price', $product->price);
            $response->assertJsonPath('data.meta.quantity', $qty);
        }
    }
}
