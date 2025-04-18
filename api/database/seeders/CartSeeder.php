<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->first();

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->seed_cart_products($cart);
    }

    protected function seed_cart_products(Cart $cart) : void
    {
        $products = Product::all()->random([1, 3, 5][rand(0, 2)]);
        $totalValue = 0;

        foreach ($products as $product) {
            $qty = rand(1, 5);
            $cart->products()->withTimestamps()
                ->attach($product, [
                'quantity' => $qty,
            ]);
            $totalValue += $product->price * $qty;
        }

        $cart->update([
            'total_value' => $totalValue,
        ]);
    }
}
