<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Tests\Integration\Stub\AllRequestDataStub;
use Maksi\LaravelRequestMapper\Tests\Integration\Stub\HeaderRequestDataStub;
use Maksi\LaravelRequestMapper\Tests\Integration\Stub\JsonRequestDataStub;

/**
 * Class DtoResolvingTest
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration
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

    /**
     * @expectedException \Maksi\LaravelRequestMapper\ValidationException\JsonResponsableException
     */
    public function testInvalidAllRequestData(): void
    {
        $this->modifyJsonRequest();
        /** @var AllRequestDataStub $dto */
        $this->app->make(AllRequestDataStub::class);
    }

    public function testJsonRequestData(): void
    {
        $this->modifyJsonRequest();
        /** @var AllRequestDataStub $dto */
        $dto = $this->app->make(JsonRequestDataStub::class);

        $this->assertInstanceOf(JsonRequestDataStub::class, $dto);
        $this->assertSame('title1', $dto->getTitle());
        $this->assertSame(2, $dto->getAge());
    }

    /**
     * @expectedException \Maksi\LaravelRequestMapper\ValidationException\JsonResponsableException
     */
    public function testInvalidJsonRequestData(): void
    {
        $this->modifyQueryRequest();
        /** @var AllRequestDataStub $dto */
        $this->app->make(JsonRequestDataStub::class);
    }

    public function testHeaderRequestData(): void
    {
        $this->modifyHeaderRequest();
        /** @var HeaderRequestDataStub $dto */
        $dto = $this->app->make(HeaderRequestDataStub::class);

        $this->assertInstanceOf(HeaderRequestDataStub::class, $dto);
        $this->assertSame(['title1'], $dto->getTitle());
        $this->assertSame([2], $dto->getAge());
    }

    /**
     * @expectedException \Maksi\LaravelRequestMapper\ValidationException\JsonResponsableException
     */
    public function testInvalidHeaderData(): void
    {
        $this->modifyQueryRequest();
        /** @var AllRequestDataStub $dto */
        $this->app->make(HeaderRequestDataStub::class);
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

    private function modifyHeaderRequest(): void
    {
        /** @var Request $request */
        $request = $this->app->make(Request::class);
        $request->headers->set('title', 'title1');
        $request->headers->set('age', 2);
    }
}
