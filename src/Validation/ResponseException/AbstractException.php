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
     * TODO: delete error, should be just an constructor.
     *
     * @param ErrorCollection $errorCollection
     */
    final public function setErrorCollection(ErrorCollection $errorCollection): void
    {
        $this->errorCollection = $errorCollection;
    }
}
