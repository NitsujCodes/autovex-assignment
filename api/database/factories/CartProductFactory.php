<?php

namespace Database\Factories;

use App\Models\CartProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CartProduct>
 */
class CartProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(1, 10),
        ];
    }
}
