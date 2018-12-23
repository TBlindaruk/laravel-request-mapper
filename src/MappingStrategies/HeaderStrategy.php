<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\MappingStrategies;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\RequestData\HeaderRequestData;
use Maksi\LaravelRequestMapper\RequestData\RequestData;

/**
 * TODO: Unit tests
 *
 * Class HeaderStrategy
 *
 * @package Maksi\LaravelRequestMapper\MappingStrategies
 */
class HeaderStrategy implements StrategyInterface
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function resolve(Request $request): array
    {
        return $request->headers->all();
    }

    /**
     * @param Request     $request
     * @param RequestData $object
     *
     * @return bool
     */
    public function support(Request $request, RequestData $object): bool
    {
        return $object instanceof HeaderRequestData;
    }
}