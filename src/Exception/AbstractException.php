<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Exception;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * TODO: rename me
 *
 * Class AbstractException
 *
 * @package Maksi\RequestMapperL\Exception
 */
abstract class AbstractException extends Exception implements Responsable
{
    /**
     * @var ConstraintViolationListInterface
     */
    protected $constraintViolationList;

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     */
    final public function setConstraintViolationList(ConstraintViolationListInterface $constraintViolationList): void
    {
        $this->constraintViolationList = $constraintViolationList;
    }
}
