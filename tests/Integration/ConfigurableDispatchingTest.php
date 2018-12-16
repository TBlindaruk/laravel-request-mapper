<?php
declare(strict_types = 1);

namespace Tests\Integration;

use Maksi\RequestMapperL\RequestMapperProvider;
use Tests\Integration\Stub\InvalidCustomObject;
use Tests\Integration\Stub\RequestMapperServiceProvider;
use Tests\Integration\Stub\ValidCustomObject;

/**
 * Class ConfigurableDispatchingTest
 *
 * @package Tests\Integration
 */
class ConfigurableDispatchingTest extends TestCase
{
    /**
     * @return void
     */
    public function testValidResolving(): void
    {
        /** @var ValidCustomObject $dto */
        $dto = $this->app->make(ValidCustomObject::class);
        $this->assertInstanceOf(ValidCustomObject::class, $dto);
        $this->assertSame(['Symfony'], $dto->getUserAgent());
    }

    /**
     * @expectedException \Maksi\RequestMapperL\Exception\RequestMapperException
     */
    public function testInvalidResolving(): void
    {
        $dto = $this->app->make(InvalidCustomObject::class);
        $this->assertInstanceOf(InvalidCustomObject::class, $dto);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            RequestMapperProvider::class,
            RequestMapperServiceProvider::class,
        ];
    }
}
