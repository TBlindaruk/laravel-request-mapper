<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Filling\RequestData;

use BadMethodCallException;
use ReflectionClass;

/**
 * Class RequestData
 *
 * @package Maksi\LaravelRequestMapper\Filling\RequestData
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
}
