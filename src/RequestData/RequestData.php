<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\RequestData;

use BadMethodCallException;
use ReflectionClass;

/**
 * Class RequestData
 *
 * @package Maksi\LaravelRequestMapper\RequestData
 */
abstract class RequestData
{
    /**
     * DataTransferObject constructor.
     *
     * @param array $data
     */
    final public function __construct(array $data = [])
    {
        $this->init($data);
    }

    /**
     * @param array $data
     */
    abstract protected function init(array $data): void;

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function __call(string $name, array $arguments)
    {
        $methodPrefix = substr($name, 0, 3);

        if (!$methodPrefix === 'get') {
            throw new BadMethodCallException(
                sprintf('method with name %s not allowed', $name)
            );
        }

        $methodSuffix = substr($name, 3);

        $class = new ReflectionClass(static::class);
        foreach ($class->getProperties() as $property) {
            if ($property->getName() === $methodSuffix) {
                return $property->getValue($this);
            }
        }

        throw new BadMethodCallException(
            sprintf('method with name %s not allowed', $name)
        );
    }

}
