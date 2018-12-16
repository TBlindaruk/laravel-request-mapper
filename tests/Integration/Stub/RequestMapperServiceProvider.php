<?php
declare(strict_types = 1);

namespace Tests\Integration\Stub;

use Illuminate\Http\Request;

/**
 * Class RequestMapperServiceProvider
 *
 * @package Tests\Integration\Stub
 */
class RequestMapperServiceProvider extends \Maksi\RequestMapperL\Support\RequestMapperServiceProvider
{
    /**
     * @param Request $request
     *
     * @return array
     */
    protected function resolveMap(Request $request): array
    {
        return [
            ValidCustomObject::class => $request->headers->all(),
            InvalidCustomObject::class => $request->headers->all(),
        ];
    }
}
