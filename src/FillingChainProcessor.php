<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\Exception\HandlerNotFoundException;
use Maksi\LaravelRequestMapper\Filling\RequestData\RequestData;
use Maksi\LaravelRequestMapper\Filling\Strategies\StrategyInterface;
use Maksi\LaravelRequestMapper\Validation\Data\ValidateData;
use Maksi\LaravelRequestMapper\Validation\ValidationProcessor;

/**
 * Class FillingChainProcessor
 *
 * @package Maksi\LaravelRequestMapper
 */
class FillingChainProcessor
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ValidationProcessor
     */
    private $validationHandler;

    /**
     * @var array|StrategyInterface[]
     */
    private $strategies = [];

    /**
     * StrategiesHandler constructor.
     *
     * @param Request             $request
     * @param ValidationProcessor $validationHandler
     */
    public function __construct(Request $request, ValidationProcessor $validationHandler)
    {
        $this->request = $request;
        $this->validationHandler = $validationHandler;
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
     *
     * @throws Validation\ResponseException\AbstractException
     */
    public function handle(RequestData $object): void
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->support($this->request, $object)) {
                $data = $strategy->resolve($this->request);
                $this->validationHandler->validateBeforeFilling(new ValidateData($object, $data));
                $object->__construct($data);

                return;
            }
        }

        throw new HandlerNotFoundException(
            sprintf('no handler found for %s class', \get_class($object))
        );
    }
}
