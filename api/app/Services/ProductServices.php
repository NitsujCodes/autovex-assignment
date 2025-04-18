<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\StorageFile;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductServices
{
    /**
     * Get all products
     *
     * @return Collection
     */
    public static function getProducts(): Collection
    {
        return Product::query()->with('images')->get();
    }

    /**
     * Get Products paginated
     * @param int|null $perPage
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public static function getProductsPaginated(?int $perPage = null, ?int $page = null): LengthAwarePaginator
    {
        return Product::query()
            ->with('images')
            ->paginate(
                perPage: $perPage,
                page: $page
            );
    }

    /**
     * Get products paginated by cart
     *
     * @param int|Cart $cart
     * @param int|null $perPage
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public static function getProductsPaginatedByCart(int|Cart $cart, ?int $perPage = null, ?int $page = null): LengthAwarePaginator
    {
        if (!is_int($cart)) {
            $cart = $cart->{$cart->primaryKey};
        }

        return CartProduct::query()
            ->with('product.images')
            ->where('cart_id', $cart)
            ->paginate(
                perPage: $perPage,
                page: $page
            );
    }

    /**
     * Get product by id
     *
     * @param int $id
     * @return Product
     */
    public static function getProduct(int $id): Product
    {
        return Product::query()->findOrFail($id);
    }

    /**
     * Create Product
     *
     * @param array $data
     * @return Product
     * @throws Exception
     */
    public static function createProduct(array $data): Product
    {
        if (empty($data)) {
            throw new Exception('Product must have at least one field to create');
        }

        return Product::query()->create($data);
    }

    /**
     * Update Product
     *
     * @param int|Product $product
     * @param array $data
     * @return Product
     * @throws Exception
     */
    public static function updateProduct(int|Product $product, array $data): Product
    {
        if (empty($data)) {
            throw new Exception('Product must have at least one field to update');
        }

        if (is_int($product)) {
            $product = Product::query()->findOrFail($product);
        }

        $product->update($data);
        return $product;
    }

    /**
     * Delete Product
     *
     * @param int|Product $product
     * @return void
     * @throws Exception
     */
    public static function deleteProduct(int|Product $product): void
    {
        if (!Product::query()->findOrFail($product)->delete()) {
            throw new Exception('Product not found or product could not be deleted');
        }
    }

    /**
     * Add image to product with pivot data
     *
     * @param int|Product $product
     * @param StorageFile $storageFile
     * @param array $data
     * @return void
     */
    public static function addImageToProduct(int|Product $product, StorageFile $storageFile, array $data): void
    {
        if (is_int($product)) {
            $product = Product::query()->findOrFail($product);
        }

        if (!isset($data['order'])) {
            $data['order'] = $product->images()->max('order') + 1;
        }

        $data['storage_file_id'] = $storageFile->{$storageFile->primaryKey};

        // TODO: Implement image specific details

        $product->images()->create($data);
    }
}
