<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Services\ProductServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductServices $productServices) : ResourceCollection
    {
        $perPage = request()->get('perPage', 10);
        $page = request()->get('page', null);

        return ProductResource::collection(
            $productServices->getProductsPaginated($perPage, $page)
            ->appends(request()->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     * @throws Exception
     */
    public function store(Request $request, ProductServices $productServices) : ProductResource
    {
        $newProduct = $productServices->createProduct($request->all());
        return new ProductResource($newProduct);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, ProductServices $productServices) : ProductResource
    {
        return new ProductResource($productServices->getProduct($id));
    }

    /**
     * Update the specified resource in storage.
     * @throws Exception
     */
    public function update(ProductServices $productServices, $request, string $id) : ProductResource
    {
        $product = $productServices->updateProduct($id, $request->all());
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     * @throws Exception
     */
    public function destroy(ProductServices $productServices, string $id) : void
    {
        $productServices->deleteProduct($id);
    }
}
