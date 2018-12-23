<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\ValidationException;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class AbstractException
 *
 * @package Maksi\LaravelRequestMapper\ValidationException
 */
abstract class AbstractException extends Exception
{
    /**
     * @var ConstraintViolationListInterface|null
     */
    protected $constraintViolationList;

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    final public function setConstraintViolationList(ConstraintViolationListInterface $constraintViolationList): void
    {
        $this->constraintViolationList = $constraintViolationList;
    }

    /**
     * @return null|ConstraintViolationListInterface
     */
    final public function getConstraintViolationList(): ?ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}
