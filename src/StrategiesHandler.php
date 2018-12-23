<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Exception\HandlerNotFoundException;
use Maksi\LaravelRequestMapper\MappingStrategies\StrategyInterface;
use Maksi\LaravelRequestMapper\RequestData\RequestData;

/**
 * Class StrategiesHandler
 *
 * @package Maksi\LaravelRequestMapper
 */
class StrategiesHandler
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var array|StrategyInterface[]
     */
    private $strategies = [];

    /**
     * StrategiesHandler constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

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
        // TODO: add unit test
        foreach ($this->strategies as $strategy) {
            if ($strategy->support($this->request, $object)) {
                $data = $strategy->resolve($this->request);
                $object->__construct($data);

                return;
            }
        }
        // TODO: end unit test

        throw new HandlerNotFoundException(
            sprintf('no handler found for %s class', \get_class($object))
        );
    }
}
