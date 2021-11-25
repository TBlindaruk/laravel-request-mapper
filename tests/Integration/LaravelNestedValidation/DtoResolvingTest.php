<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub\RootRequestDataStub;
use Maksi\LaravelRequestMapper\Tests\Integration\TestCase;
use Maksi\LaravelRequestMapper\Validation\ResponseException\JsonResponsableException;

/**
 * Class DtoResolvingTest
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration\AnnotationNestedValidation
 */
class DtoResolvingTest extends TestCase
{
    public function testValidNestedRequestData(): void
    {
        /** @var Request $request */
        $request = $this->app->make(Request::class);
        $request->json()->set('title', 'title1');
        $request->json()->set('nested', ['title' => 'nested_title']);

        /** @var RootRequestDataStub $dto */
        $dto = $this->app->make(RootRequestDataStub::class);
        $this->assertInstanceOf(RootRequestDataStub::class, $dto);
        $this->assertSame('title1', $dto->getTitle());
        $this->assertSame('nested_title', $dto->getNested()->getTitle());
    }

    public function testInvalidNestedRequestData(): void
    {
        $this->expectException(JsonResponsableException::class);
        /** @var Request $request */
        $request = $this->app->make(Request::class);
        $request->json()->set('title', 'title1');
        $request->json()->set('nested', []);

        $dto = $this->app->make(RootRequestDataStub::class);
    }

    public function testInvalidNestedRequestDataException(): void
    {
        /** @var Request $request */
        $request = $this->app->make(Request::class);
        $request->json()->set('title', 'title1');
        $request->json()->set('nested', []);

        try {
            $this->app->make(RootRequestDataStub::class);
        } catch (JsonResponsableException $exception) {
            $this->assertValidationResponseValidation($exception, [
                'errors' => [
                    [
                        'message' => 'The nested field is required.',
                        'property' => 'nested',
                    ],
                    [
                        'message' => 'The nested.title field is required.',
                        'property' => 'nested.title',
                    ],
                ],
            ], 422);
        }
    }
}
