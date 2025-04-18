<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    /**
     * Check if JSON Response is a valid paginated response
     * @param TestResponse $response
     * @param string $path
     * @param int $perPage
     * @param string|null $firstLink
     * @param string|null $lastLink
     * @param string|null $prevLink
     * @param string|null $nextLink
     * @param int|null $metaCurrentPage
     * @param int|null $metaFrom
     * @param int|null $metaLastPage
     * @param int|null $metaTo
     * @param int|null $metaTotal
     * @return void
     */
    protected function assertValidPaginatedJsonResponse(
        TestResponse $response, string $path, int $perPage, ?string $firstLink = null, ?string $lastLink = null,
        ?string $prevLink = null, ?string $nextLink = null, ?int $metaCurrentPage = null, ?int $metaFrom = null,
        ?int $metaLastPage = null, ?int $metaTo = null, ?int $metaTotal = null
    ) : void
    {
        $response->assertJsonStructure([
            'data' => [],
            'links' => [],
            'meta' => [],
        ]);

        $response->assertJsonPath('meta.path', $path);
        $response->assertJsonPath('meta.per_page', $perPage);

        if (!is_null($metaCurrentPage)) {
            $response->assertJsonPath('meta.current_page', $metaCurrentPage);
        }
        if (!is_null($metaFrom)) {
            $response->assertJsonPath('meta.from', $metaFrom);
        }
        if (!is_null($metaLastPage)) {
            $response->assertJsonPath('meta.last_page', $metaLastPage);
        }
        if (!is_null($metaTo)) {
            $response->assertJsonPath('meta.to', $metaTo);
        }
        if (!is_null($metaTotal)) {
            $response->assertJsonPath('meta.total', $metaTotal);
        }

        if (!is_null($firstLink)) {
            $response->assertJsonPath('links.first', $firstLink);
        }
        if (!is_null($lastLink)) {
            $response->assertJsonPath('links.last', $lastLink);
        }
        if (!is_null($prevLink)) {
            $response->assertJsonPath('links.prev', $prevLink);
        }
        if (!is_null($nextLink)) {
            $response->assertJsonPath('links.next', $nextLink);
        }
    }

    /**
     * Check if JSON Response is a valid data response
     * @param TestResponse $response
     * @param array|null $expectedStructure [optional] This is for testing if specific paths exist within data
     * @return void
     */
    protected function assertValidJsonDataResponse(TestResponse $response, ?array $expectedStructure = null) : void
    {
        $response->assertJsonStructure([
            'data' => [],
        ]);

        if (!is_null($expectedStructure)) {
            foreach ($expectedStructure as $key => $value) {
                $response->assertJsonPath("data.{$key}", $value);
            }
        }
    }

    /**
     * Check if data in response matches the payload
     * @param TestResponse $response
     * @param array $payload
     * @return void
     */
    protected function assertResponseDataMatchesPayload(TestResponse $response, array $payload) : void
    {
        $responseData = $response->json('data');

        $this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys(
            $payload,
            $responseData,
            array_keys($payload)
        );
    }
}
