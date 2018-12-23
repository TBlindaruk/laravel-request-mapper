<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\MappingStrategies;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\RequestData\RequestData;

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
