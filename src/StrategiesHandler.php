<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL;

use Maksi\RequestMapperL\MappingStrategies\StrategyInterface;
use Maksi\RequestMapperL\RequestData\RequestData;

/**
 * Class StrategiesHandler
 *
 * @package Maksi\RequestMapperL
 */
class StrategiesHandler
{
    /**
     * @var array|StrategyInterface[]
     */
    private $strategies = [];

    /**
     * @param StrategyInterface $strategy
     *
     * @return $this
     */
    public function addStrategy(StrategyInterface $strategy): self
    {
        $this->strategies[] = $strategy;

        return $this;
    }

    /**
     * @param RequestData $object
     */
    public function handle(RequestData $object): void
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->support($object)) {
                $data = $strategy->resolve($object);
                $object->__construct($data);

                break;
            }
        }
    }
}