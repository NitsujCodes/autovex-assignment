<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CartProductResource;
use App\Http\Resources\V1\ProductResource;
use App\Models\Cart;
use App\Services\CartServices;
use App\Services\ProductServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Cart $cart, ProductServices $productServices) : ResourceCollection
    {
        $perPage = request()->get('perPage', 10);
        $page = request()->get('page', null);

        return CartProductResource::collection(
            $productServices->getProductsPaginatedByCart($cart, $perPage, $page)
        );
    }

    /**
     * Store a newly created resource in storage.
     * @throws Exception
     */
    public function store(Cart $cart, Request $request, ProductServices $productServices, CartServices $cartServices) : ProductResource
    {
        $productId = $request->post('product_id');
        $quantity = $request->post('quantity', 1);
        $product = ProductServices::getProduct($productId);

        if ($quantity < 1) {
            abort(403);
        }

        $cartProduct = $cartServices->addProductToCart($cart, $product, [
            'quantity' => $request->post('quantity', 1)
        ]);

        return new ProductResource($cartProduct);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart, string $productId)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Cart $cart, string $productId, Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $cartId, string $productId)
    {
        //
    }
}
