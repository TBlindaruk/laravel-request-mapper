<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper;

use Maksi\LaravelRequestMapper\RequestData\RequestData;

/**
 * TODO: tests
 *
 * Class Resolver
 *
 * @package Maksi\LaravelRequestMapper
 */
class Resolver
{
    /**
     * @var StrategiesHandler
     */
    private $handler;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * Resolver constructor.
     *
     * @param Validator         $validator
     * @param StrategiesHandler $handler
     */
    public function __construct(Validator $validator, StrategiesHandler $handler)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    /**
     * @param RequestData $data
     *
     * @throws Exception\AbstractException
     * @throws Exception\RequestMapperException
     */
    public function resolve(RequestData $data): void
    {
        $this->handler->handle($data);
        $this->validator->applyAfterResolvingValidation($data);
    }
}
