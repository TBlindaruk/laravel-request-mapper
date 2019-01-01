<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\ResponseException;

use Exception;
use Maksi\LaravelRequestMapper\Validation\Data\ErrorCollection;

/**
 * Class AbstractException
 *
 * @package Maksi\LaravelRequestMapper\Validation\ResponseException
 */
abstract class AbstractException extends Exception
{
    /**
     * @var ErrorCollection|null
     */
    protected $errorCollection;

    /**
     * @param ErrorCollection $errorCollection
     */
    final public function setErrorCollection(ErrorCollection $errorCollection): void
    {
        $this->errorCollection = $errorCollection;
    }

    /**
     * @return ErrorCollection|null
     */
    final public function getErrorCollection(): ?ErrorCollection
    {
        return $this->errorCollection;
    }
}
