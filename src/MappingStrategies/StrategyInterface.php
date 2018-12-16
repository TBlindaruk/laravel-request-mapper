<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL\MappingStrategies;

use Maksi\RequestMapperL\RequestData\RequestData;

/**
 * Interface StrategyInterface
 *
 * @package Maksi\RequestMapperL\MappingStrategies
 */
interface StrategyInterface
{
    /**
     * @param RequestData $object
     *
     * @return array
     */
    public function resolve(RequestData $object): array ;

    /**
     * @param RequestData $object
     *
     * @return bool
     */
    public function support(RequestData $object): bool;
}
