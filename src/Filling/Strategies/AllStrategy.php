<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Filling\Strategies;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Filling\RequestData\AllRequestData;
use Maksi\LaravelRequestMapper\Filling\RequestData\RequestData;

/**
 * TODO: Unit tests
 * Class AllStrategy
 *
 * @package Maksi\LaravelRequestMapper\Filling\Strategies
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
