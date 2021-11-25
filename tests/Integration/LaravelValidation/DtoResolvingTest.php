<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelValidation;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Tests\Integration\LaravelValidation\Stub\AllRequestDataStub;
use Maksi\LaravelRequestMapper\Tests\Integration\TestCase;
use Maksi\LaravelRequestMapper\Validation\ResponseException\JsonResponsableException;

/**
 * Class DtoResolvingTest
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration\LaravelValidation
 */
class DtoResolvingTest extends TestCase
{
    public function testAllRequestData(): void
    {
        $this->modifyQueryRequest();

        /** @var AllRequestDataStub $dto */
        $dto = $this->app->make(AllRequestDataStub::class);
        $this->assertInstanceOf(AllRequestDataStub::class, $dto);
        $this->assertSame('title1', $dto->getTitle());
        $this->assertSame(2, $dto->getAge());
    }

    public function testInvalidAllRequestData(): void
    {
        $this->expectException(JsonResponsableException::class);
        $this->modifyJsonRequest();

        $this->app->make(AllRequestDataStub::class);
    }

    public function testInvalidHeaderDataException(): void
    {
        $this->modifyJsonRequest();
        try {
            $this->app->make(AllRequestDataStub::class);
        } catch (JsonResponsableException $jsonResponsableException) {
            $this->assertValidationResponseValidation($jsonResponsableException, [
                'errors' => [
                    [
                        'message' => 'The age field is required.',
                        'property' => 'age',
                    ],
                    [
                        'message' => 'The title field is required.',
                        'property' => 'title',
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

    private function modifyJsonRequest(): void
    {
        /** @var Request $request */
        $request = $this->app->make(Request::class);
        $request->json()->set('title', 'title1');
        $request->json()->set('age', 2);
    }
}
