<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Unit;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Exception\HandlerNotFoundException;
use Maksi\LaravelRequestMapper\FillingChainProcessor;
use Maksi\LaravelRequestMapper\Tests\Unit\Stub\JsonRequestDataStub;
use Maksi\LaravelRequestMapper\Validation\ValidationProcessor;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class FillingChainProcessorTest
 *
 * @package Maksi\LaravelRequestMapper\Tests\Unit
 */
class FillingChainProcessorTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $validationProcessor;

    public function setUp(): void
    {
        $this->validationProcessor = parent::getMockBuilder(ValidationProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @throws \Maksi\LaravelRequestMapper\Validation\ResponseException\AbstractException
     */
    public function testHandlerNotFoundException():void
    {
        $this->expectException(HandlerNotFoundException::class);
        $this->expectExceptionMessage("no handler found for Maksi\LaravelRequestMapper\Tests\Unit\Stub\JsonRequestDataStub class");
        $fillingChainProcessor = $this->createFillingChainProcessor();
        $fillingChainProcessor->handle(new JsonRequestDataStub([]));
    }

    /**
     * @return FillingChainProcessor
     */
    private function createFillingChainProcessor(): FillingChainProcessor
    {
        return new FillingChainProcessor(
            new Request(),
            $this->validationProcessor
        );
    }
}
