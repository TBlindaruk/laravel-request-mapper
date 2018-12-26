<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Filling\Strategies;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Filling\RequestData\RequestData;

/**
 * Interface StrategyInterface
 *
 * @package Maksi\RequestMapperL\MappingStrategies
 */
interface StrategyInterface
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function resolve(Request $request): array;

    /**
     * @param Request     $request
     * @param RequestData $object
     *
     * @return bool
     */
    public function support(Request $request, RequestData $object): bool;
}
