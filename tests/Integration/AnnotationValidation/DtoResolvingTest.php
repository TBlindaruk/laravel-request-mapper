<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation\Stub\AllRequestDataStub;
use Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation\Stub\HeaderRequestDataStub;
use Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation\Stub\JsonRequestDataStub;
use Maksi\LaravelRequestMapper\Tests\Integration\TestCase;
use Maksi\LaravelRequestMapper\Validation\ResponseException\JsonResponsableException;

/**
 * Class DtoResolvingTest
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation
 */
class DtoResolvingTest extends TestCase
{
    public function testAllRequestData(): void
    {
        $this->modifyQueryRequest();

        /** @var AllRequestDataStub $dto */
        $dto = $this->app->make(AllRequestDataStub::class);
        $this->assertInstanceOf(AllRequestDataStub::class, $dto);
        $this->assertSame('title1', $dto->getAllTitle());
        $this->assertSame(2, $dto->getAllAge());
    }

    /**
     * @expectedException \Maksi\LaravelRequestMapper\Validation\ResponseException\JsonResponsableException
     */
    public function testInvalidAllRequestData(): void
    {
        $this->modifyJsonRequest();

        $this->app->make(AllRequestDataStub::class);
    }

    public function testInvalidAllRequestDataException(): void
    {
        $this->modifyJsonRequest();
        try {
            $this->app->make(AllRequestDataStub::class);
        } catch (JsonResponsableException $jsonResponsableException) {
            $this->assertValidationResponseValidation($jsonResponsableException, [
                'errors' => [
                    [
                        'message' => 'This value should not be blank.',
                        'property' => 'allAge',
                    ],
                    [
                        'message' => 'This value should not be blank.',
                        'property' => 'allTitle',
                    ],
                ],
            ], 422);
        }
    }

    public function testJsonRequestData(): void
    {
        $this->modifyJsonRequest();
        /** @var JsonRequestDataStub $dto */
        $dto = $this->app->make(JsonRequestDataStub::class);

        $this->assertInstanceOf(JsonRequestDataStub::class, $dto);
        $this->assertSame('title1', $dto->getJsonTitle());
        $this->assertSame(2, $dto->getJsonAge());
    }

    /**
     * @expectedException \Maksi\LaravelRequestMapper\Validation\ResponseException\JsonResponsableException
     */
    public function testInvalidJsonRequestData(): void
    {
        $this->modifyQueryRequest();

        $this->app->make(JsonRequestDataStub::class);
    }

    public function testInvalidJsonRequestDataException(): void
    {
        $this->modifyQueryRequest();
        try {
            $this->app->make(JsonRequestDataStub::class);
        } catch (JsonResponsableException $jsonResponsableException) {
            $this->assertValidationResponseValidation($jsonResponsableException, [
                'errors' => [
                    [
                        'message' => 'This value should not be blank.',
                        'property' => 'jsonAge',
                    ],
                    [
                        'message' => 'This value should not be blank.',
                        'property' => 'jsonTitle',
                    ],
                ],
            ], 422);
        }
    }

    public function testHeaderRequestData(): void
    {
        $this->modifyHeaderRequest();
        /** @var HeaderRequestDataStub $dto */
        $dto = $this->app->make(HeaderRequestDataStub::class);
        $this->assertInstanceOf(HeaderRequestDataStub::class, $dto);
        $this->assertSame(['title1'], $dto->getHeaderTitle());
        $this->assertSame([2], $dto->getHeaderAge());
    }

    /**
     * @expectedException \Maksi\LaravelRequestMapper\Validation\ResponseException\JsonResponsableException
     */
    public function testInvalidHeaderData(): void
    {
        $this->modifyQueryRequest();

        $this->app->make(HeaderRequestDataStub::class);
    }

    public function testInvalidHeaderDataException(): void
    {
        $this->modifyQueryRequest();
        try {
            $this->app->make(HeaderRequestDataStub::class);
        } catch (JsonResponsableException $jsonResponsableException) {
            $this->assertValidationResponseValidation($jsonResponsableException, [
                'errors' => [
                    [
                        'message' => 'This value should not be blank.',
                        'property' => 'headerAge',
                    ],
                    [
                        'message' => 'This value should not be blank.',
                        'property' => 'headerTitle',
                    ],
                ],
            ], 422);
        }
    }

    private function modifyQueryRequest(): void
    {
        /** @var Request $request */
        $request = $this->app->make(Request::class);
        $request->query->set('title', 'title1');
        $request->query->set('age', 2);
    }

    private function modifyHeaderRequest(): void
    {
        /** @var Request $request */
        $request = $this->app->make(Request::class);
        $request->headers->set('title', 'title1');
        $request->headers->set('age', 2);
    }

    private function modifyJsonRequest(): void
    {
        /** @var Request $request */
        $request = $this->app->make(Request::class);
        $request->json()->set('title', 'title1');
        $request->json()->set('age', 2);
    }
}
