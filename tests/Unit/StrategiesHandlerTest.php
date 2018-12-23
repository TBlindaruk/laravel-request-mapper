<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Unit;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\StrategiesHandler;
use Maksi\LaravelRequestMapper\Tests\Integration\Stub\JsonRequestDataStub;
use Maksi\LaravelRequestMapper\Tests\Integration\TestCase;

/**
 * Class StrategiesHandlerTest
 *
 * @package Maksi\LaravelRequestMapper\Tests\Unit
 */
class StrategiesHandlerTest extends TestCase
{
    /**
     * @expectedException \Maksi\LaravelRequestMapper\Exception\HandlerNotFoundException
     */
    public function testHandlerNotFoundException(): void
    {
        $strategiesHandler = new StrategiesHandler(new Request());
        $strategiesHandler->handle(new JsonRequestDataStub());
    }
}
