<?php

namespace Tests\Feature\Api\V1\Product;

use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_endpoint_create() : void
    {
        $payloadModel = Product::factory()->make();
        $payload = $payloadModel->only($payloadModel->getFillable());

        // Test response
        $response = $this->postJson('/api/v1/product', $payload);
        // Did we return code 201?
        $response->assertCreated();
        // Is the structure paginated as expected? and has the right data?
        $this->assertValidJsonDataResponse($response);
        $this->assertResponseDataMatchesPayload($response, $payload);

        // Check if actually exists in db
        $this->assertDatabaseHas('products', $payload);
    }

    public function test_endpoint_list_no_data() : void
    {
        $path = '/api/v1/product';
        $perPage = 10;

        $response = $this->getJson($path);
        // Response success?
        $response->assertOk();
        // Structure is pagination structure?
        $this->assertValidPaginatedJsonResponse(
            $response,
            url($path),
            $perPage
        );
        $response->assertJsonCount(0, 'data');
    }

    public function test_endpoint_list_with_data() : void
    {
        $listProductsPath = '/api/v1/product';
        $productsPerPage = 10;

        $productCollection = Product::factory()->count(10)->create();
        $response = $this->getJson($listProductsPath);
        // Response success?
        $response->assertOk();
        // Is the response a paginated response?
        $this->assertValidPaginatedJsonResponse(
            response: $response,
            path: url($listProductsPath),
            perPage: $productsPerPage,
        );

        // TODO: Assert that the correct products are listed and in order
    }

    public function test_endpoint_list_with_pages() : void
    {
        $listProductsPath = '/api/v1/product';
        $productCount = 20;
        $productsPerPage = 5;

        $productCollection = Product::factory()->count($productCount)->create();
        $response = $this->getJson("$listProductsPath?perPage=5");
        // Response success?
        $response->assertOk();
        // Is the response a paginated response?
        $this->assertValidPaginatedJsonResponse(
            response: $response,
            path: url($listProductsPath),
            perPage: $productsPerPage,
            metaCurrentPage: 1,
            metaLastPage: ceil($productCount / $productsPerPage),
            metaTotal: $productCount,
        );
    }

    public function test_endpoint_show() : void
    {
        //
    }

    public function test_endpoint_update() : void
    {
        //
    }

    public function test_endpoint_delete() : void
    {
        //
    }

    public function test_endpoint_add_image() : void
    {
        //
    }

    public function test_endpoint_remove_image() : void
    {
        //
    }

    public function test_endpoint_list_images() : void
    {

    }
}
