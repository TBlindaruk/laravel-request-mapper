<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Tests\Integration\Stub\Laravel\AllRequestDataStub;

/**
 * Class DtoResolvingTest
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration
 */
class LaravelValidationTest extends TestCase
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

    /**
     * @expectedException \Maksi\LaravelRequestMapper\Validation\ResponseException\JsonResponsableException
     */
    public function testInvalidAllRequestData(): void
    {
        $this->modifyJsonRequest();
        /** @var AllRequestDataStub $dto */
        $this->app->make(AllRequestDataStub::class);
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
