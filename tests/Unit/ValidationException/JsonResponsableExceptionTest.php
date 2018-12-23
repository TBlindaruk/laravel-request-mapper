<?php
declare(strict_types = 1);

namespace Tests\Unit\ValidationException;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\ValidationException\DefaultException;
use Maksi\LaravelRequestMapper\ValidationException\JsonResponsableException;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonResponsableExceptionTest
 *
 * @package Tests\Unit\ValidationException
 */
class JsonResponsableExceptionTest extends TestCase
{
    /**
     * @return void
     */
    public function testToResponseWithEmptyError(): void
    {
        $exception = new JsonResponsableException();

        $response = $exception->toResponse(new Request());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame('{"errors":[]}', $response->getContent());
        $this->assertSame(422, $response->getStatusCode());
    }
}
