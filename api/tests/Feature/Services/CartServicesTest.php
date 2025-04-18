<?php

namespace Tests\Feature\Services;


use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Services\CartServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartServicesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_cart_value_and_vat() : void
    {
        $user = User::factory()->create();

        $cartConfig = [
            [
                'product_count' => 1,
            ],
            [
                'product_count' => 3,
            ],
            [
                'product_count' => 5,
            ]
        ];

        $carts = Cart::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);
        $products = Product::factory()->count(50)->create();

        $expectedTotalValue = 0;
        foreach ($cartConfig as $cartSettings) {
            $cart = $carts->pop();
            // Select random products to ensure random pricing
            $selectedProducts = $products->random($cartSettings['product_count']);
            foreach ($selectedProducts as $product) {
                try {
                    CartServices::addProductToCart($cart, $product, [
                        'quantity' => 1,
                    ]);
                    $expectedTotalValue += $product->price;
                } catch (\Exception $e) {
                    self::fail($e->getMessage());
                }
            }
            $expectedVatValue = $expectedTotalValue * Cart::$vat;
            $expectedTotalValueWithVat = $expectedTotalValue + $expectedVatValue;

            // Force cart to recalculate value
            CartServices::recalculateCartValue($cart);
            $cart->refresh();

            $this->assertEquals($cart->total_value, $expectedTotalValue, "Cart Total Value Assertion Cart: {$cart->id} with {$cart->products->count()} products");
            $this->assertEquals($cart->vat_value, $expectedVatValue, 'Cart VAT Value Assertion');
            $this->assertEquals($cart->total_value_with_vat, $expectedTotalValueWithVat, 'Cart Total Value with VAT Assertion');

            $expectedTotalValue = 0;
        }
    }
}
