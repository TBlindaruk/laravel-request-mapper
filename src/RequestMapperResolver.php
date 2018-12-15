<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Container\Container;
use Maksi\RequestMapperL\Exception\AbstractException;
use Maksi\RequestMapperL\Exception\RequestMapperException;
use Symfony\Component\Validator\Exception\LogicException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestMapperResolver
 *
 * @package Maksi\RequestMapperL
 */
class RequestMapperResolver
{
    private const CONFIG_EXCEPTION_STRING = 'request-mapper-l.exception-class';

    /**
     * @var array
     */
    private $map;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * RequestMapperResolver constructor.
     *
     * @param Config             $config
     * @param Container          $container
     * @param ValidatorInterface $validator
     */
    public function __construct(Config $config, Container $container, ValidatorInterface $validator)
    {
        $this->config = $config;
        $this->container = $container;
        $this->validator = $validator;
    }

    /**
     * @param array $map
     */
    public function map(array $map): void
    {
        $this->map = $map;
        foreach ($map as $className => $arguments) {
            $this->container->singleton($className, function () use ($className, $arguments) {
                return new $className(... $arguments);
            });
            $this->container->afterResolving($className, function ($resolved) {
                $this->applyAfterResolvingValidation($resolved);
            });
        }
    }

    /**
     * @return array
     */
    public function getRegisterClass(): array
    {
        return array_keys($this->map ?? []);
    }

    /**
     * @param $resolved
     *
     * @throws AbstractException
     * @throws RequestMapperException
     */
    public function applyAfterResolvingValidation($resolved): void
    {
        $errors = $this->validator->validate($resolved);
        if ($errors->count() > 0) {
            $exception = $this->getExceptionClass();
            $exception->setConstraintViolationList($errors);
            throw $exception;
        }
    }

    /**
     * @return RequestMapperException
     */
    protected function getExceptionClass(): AbstractException
    {
        $class = new RequestMapperException();
        $className = $this->config->get(self::CONFIG_EXCEPTION_STRING);

        if ($className) {
            $class = new $className;
        }

        if (!$class instanceof AbstractException) {
            throw  new LogicException('$class should be instance of ' . AbstractException::class);
        }

        return $class;
    }
}
