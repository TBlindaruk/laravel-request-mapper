<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\RequestMapperProvider;
use Maksi\LaravelRequestMapper\Validation\ResponseException\JsonResponsableException;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class TestCase
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration
 */
class TestCase extends BaseTestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            RequestMapperProvider::class,
        ];
    }

    /**
     * @param JsonResponsableException $exception
     * @param array                    $content
     * @param int                      $statusCode
     */
    protected function assertValidationResponseValidation(
        JsonResponsableException $exception,
        array $content,
        int $statusCode
    ): void {
        $request = $this->app->make(Request::class);
        $response = $exception->toResponse($request);
        $this->assertSame(json_encode($content), $response->content());
        $this->assertSame($statusCode, $response->getStatusCode());
    }
}
