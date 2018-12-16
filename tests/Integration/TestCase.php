<?php
declare(strict_types = 1);

namespace Tests\Integration;

use Maksi\LaravelRequestMapper\RequestMapperProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class AutoDispatchingTest
 *
 * @package Tests\Integration
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
}