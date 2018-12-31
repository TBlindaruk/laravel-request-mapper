<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\AnnotationNestedValidation;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Tests\Integration\AnnotationNestedValidation\Stub\RootRequestDataStub;
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

    /**
     * @expectedException \Maksi\LaravelRequestMapper\Validation\ResponseException\JsonResponsableException
     */
    public function testInvalidNestedRequestData(): void
    {
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
                        'message' => 'This value should not be blank.',
                        'property' => 'nested.nestedTitle',
                    ],
                ],
            ], 422);
        }
    }
}
