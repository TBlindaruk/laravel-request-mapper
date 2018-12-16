<?php
declare(strict_types = 1);

namespace Tests\Unit\Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Exception\RequestMapperException;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestMapperExceptionTest
 *
 * @package Tests\Unit\Exception
 */
class RequestMapperExceptionTest extends TestCase
{
    /**
     * @return void
     */
    public function testToResponseWithEmptyError(): void
    {
        $exception = new RequestMapperException();

        $response = $exception->toResponse(new Request());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame('{"errors":[]}', $response->getContent());
        $this->assertSame(422, $response->getStatusCode());
    }
}
