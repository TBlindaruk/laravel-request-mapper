<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Filling\Strategies;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Filling\RequestData\JsonRequestData;
use Maksi\LaravelRequestMapper\Filling\RequestData\RequestData;

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
