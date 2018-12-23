<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\MappingStrategies;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\RequestData\AllRequestData;
use Maksi\LaravelRequestMapper\RequestData\RequestData;

/**
 * TODO: Unit tests
 * Class AllStrategy
 *
 * @package Maksi\LaravelRequestMapper\MappingStrategies
 */
class AllStrategy implements StrategyInterface
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function resolve(Request $request): array
    {
        return $request->all();
    }

    /**
     * @param Request     $request
     * @param RequestData $object
     *
     * @return bool
     */
    public function support(Request $request, RequestData $object): bool
    {
        return $object instanceof AllRequestData;
    }
}
