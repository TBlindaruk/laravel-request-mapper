<?php
declare(strict_types = 1);

namespace Tests\Integration;

use Illuminate\Http\Request;
use Tests\Integration\Stub\RequestDataTransferObject;

/**
 * Class AutoDispatchingTest
 *
 * @package Tests\Integration
 */
class AutoDispatchingTest extends TestCase
{
    public function testValidAutoResolving(): void
    {
        /** @var RequestDataTransferObject $dto */
        $this->app->instance(Request::class, new Request(['title' => 'title1', 'age' => 2]));

        $dto = $this->app->make(RequestDataTransferObject::class);
        $this->assertInstanceOf(RequestDataTransferObject::class, $dto);
        $this->assertSame('title1', $dto->getTitle());
    }

    /**
     * @expectedException \Maksi\RequestMapperL\Exception\RequestMapperException
     */
    public function testInvalidAutoResolving(): void
    {
        /** @var RequestDataTransferObject $dto */
        $this->app->instance(Request::class, new Request(['title1' => 'title1']));

        $dto = $this->app->make(RequestDataTransferObject::class);
        $this->assertInstanceOf(RequestDataTransferObject::class, $dto);
    }
}
