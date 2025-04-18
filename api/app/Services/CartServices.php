<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CartServices
{
    /**
     * Get cart by user id or create new cart if not found
     *
     * @param int|User $user
     * @return Cart
     */
    public static function getCartByUserIdOrCreate(int|User $user) : Cart
    {
        $userId = is_int($user) ? $user : $user->getKey();
        return Cart::query()
            ->withCount('products')
            ->where('user_id', $userId)->firstOrCreate([
                'user_id' => $userId,
            ]);
    }

    /**
     * Retrieve a cart by id
     *
     * @param int $id
     * @return Cart
     */
    public static function getCart(int $id) : Cart
    {
        return Cart::query()
            ->withCount('products')
            ->firstOrFail($id);
    }

    /**
     * Retrieve a cart by id with products
     *
     * @param int $id
     * @return Cart
     */
    public static function getCartWithProducts(int $id) : Cart
    {
        return Cart::query()
            ->with('products')
            ->firstOrFail($id);
    }

    /**
     * Get all carts
     *
     * @return Collection
     */
    public static function getCarts() : Collection
    {
        return Cart::query()->get();
    }

    /**
     * Get all carts paginated
     *
     * @param int|null $perPage
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public static function getCartsPaginated(?int $perPage = null, ?int $page = null) : LengthAwarePaginator
    {
        return Cart::query()->paginate(
            perPage: $perPage,
            page: $page,
        );
    }

    /**
     * Create Cart
     *
     * @param array $data
     * @return Cart
     */
    public static function createCart(array $data) : Cart
    {
        return Cart::query()->create($data);
    }

    /**
     * Update Existing Cart
     *
     * @param int|Cart $cart
     * @param array $data
     * @return Cart
     */
    public static function updateCart(int|Cart $cart, array $data) : Cart
    {
        if (is_int($cart)) {
            $cart = self::getCart($cart);
        }

        $cart->update($data);
        return $cart;
    }

    /**
     * Delete Cart
     *
     * @param int|Cart $cart
     * @return void
     */
    public static function deleteCart(int|Cart $cart) : void
    {
        Cart::query()->findOrFail($cart)->delete();
    }

    /**
     * Get all products in cart
     *
     * @param int|Cart $cart
     * @return Collection
     */
    public static function getProductsInCart(int|Cart $cart) : Collection
    {
        return CartProduct::query()
            ->where('cart_id', is_int($cart) ? $cart : $cart->getKey())
            ->get();
    }

    /**
     * Force recalculate cart value
     *
     * @param int|Cart $cart
     * @return void
     */
    public static function recalculateCartValue(int|Cart $cart) : void
    {
        if (is_int($cart)) {
            $cart = self::getCartWithProducts($cart);
        }

        $cart->total_value = 0;
        foreach ($cart->products()->get() as $product) {
            /** @var Product $product */
            $cart->total_value += $product->price * $product->pivot->quantity;
        }
        if ($cart->isDirty('total_value')) {
            $cart->save();
        }
    }

    /**
     * Add product to cart with pivot data
     *
     * @param int|Cart $cart
     * @param int|Product $product
     * @param array $data
     * @return Product
     * @throws Exception
     */
    public static function addProductToCart(int|Cart $cart, int|Product $product, array $data) : Product
    {
        if (empty($data)) {
            throw new Exception("Product must have quantity");
        }

        if (is_int($cart)) {
            $cart = self::getCart($cart);
        }

        if (is_int($product)) {
            $product = Product::query()->findOrFail($product);
        }

        $cart->products()->attach($product, $data);
        self::recalculateCartValue($cart);

        return $cart->products()
            ->wherePivot('product_id', $product->getKey())
            ->get()->first();
    }

    /**
     * Remove product from cart
     *
     * @param int|Cart $cart
     * @param int|Product $product
     * @return void
     * @throws Exception
     */
    public static function removeProductFromCart(int|Cart $cart, int|Product $product) : void
    {
        if (is_int($cart)) {
            $cart = self::getCart($cart);
        }

        if (is_int($product)) {
            $product = Product::query()->findOrFail($product);
        }

        $cartProduct = CartProduct::query()
            ->where('cart_id', $cart->getKey())
            ->where('product_id', $product->getKey())->first();

        if (!$cartProduct) {
            throw new Exception("Product not found in cart");
        }

        $cart->products()->detach($product);
        self::recalculateCartValue($cart);
    }

    /**
     * Remove all products from cart
     *
     * @param int|Cart $cart
     * @return void
     */
    public static function clearCart(int|Cart $cart) : void
    {
        if (is_int($cart)) {
            $cart = self::getCart($cart);
        }

        $cart->products()->detach();
        $cart->total_value = 0;
        $cart->save();
    }

    /**
     * Update product in cart with pivot data
     *
     * @param int|Cart $cart
     * @param int|Product $product
     * @param array $data
     * @return void
     * @throws Exception
     */
    public static function updateProductInCart(int|Cart $cart, int|Product $product, array $data) : void
    {
        if (is_int($cart)) {
            $cart = self::getCart($cart);
        }

        if (is_int($product)) {
            $product = Product::query()->findOrFail($product);
        }

        $cartProduct = CartProduct::query()
            ->where('cart_id', $cart)
            ->where('product_id', $product)
            ->first();

        if (!$cartProduct) {
            throw new Exception("Product not found in cart");
        }

        $cart->products()->updateExistingPivot($product, $data);
        self::recalculateCartValue($cart);
    }

    /**
     * Update product quantity in cart
     *
     * @param int|Cart $cart
     * @param int|Product $product
     * @param int $quantity
     * @return void
     * @throws Exception
     */
    public static function updateProductQuantityInCart(int|Cart $cart, int|Product $product, int $quantity) : void
    {
        self::updateProductInCart($cart, $product, ['quantity' => $quantity]);
    }
}
