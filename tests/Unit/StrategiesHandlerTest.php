<?php
declare(strict_types = 1);

namespace Tests\Unit;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\StrategiesHandler;
use Tests\Integration\Stub\JsonRequestDataStub;
use Tests\Integration\TestCase;

/**
 * Class StrategiesHandlerTest
 *
 * @package Tests\Unit
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
