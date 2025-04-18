<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CartResource;
use App\Services\CartServices;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : void
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartServices $cartServices,  $request) : CartResource
    {
        return new CartResource($cartServices->createCart($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(CartServices $cartServices, string $id) : CartResource
    {
        return new CartResource($cartServices->getCart($id));
    }

    public function showWithProducts(CartServices $cartServices, string $id) : CartResource
    {
        return new CartResource($cartServices->getCartWithProducts($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) : void
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartServices $cartServices, string $id) : void
    {
        $cartServices->deleteCart($id);
    }
}
