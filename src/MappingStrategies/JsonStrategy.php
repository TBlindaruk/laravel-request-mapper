<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\MappingStrategies;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\RequestData\JsonRequestData;
use Maksi\LaravelRequestMapper\RequestData\RequestData;

/**
 * TODO: Unit tests
 * Class JsonStrategy
 *
 * @package Maksi\RequestMapperL\MappingStrategies
 */
class JsonStrategy implements StrategyInterface
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function resolve(Request $request): array
    {
        return $request->json()->all();
    }

    /**
     * @param Request     $request
     * @param RequestData $object
     *
     * @return bool
     */
    public function support(Request $request, RequestData $object): bool
    {
        return $object instanceof JsonRequestData;
    }
}
