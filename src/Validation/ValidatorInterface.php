<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation;

use Maksi\LaravelRequestMapper\Validation\Data\ErrorCollection;
use Maksi\LaravelRequestMapper\Validation\Data\ValidateData;

/**
 * Interface HandlerInterface
 *
 * @package Maksi\LaravelRequestMapper\Validation
 */
interface ValidatorInterface
{
    /**
     * Validate data and return error collection, if invalid
     *
     * @param ValidateData $validateData
     *
     * @return ErrorCollection
     */
    public function validate(ValidateData $validateData): ErrorCollection;

    /**
     * Determine if handler should handle validation for data
     *
     * @param ValidateData $validateData
     *
     * @return bool
     */
    public function support(ValidateData $validateData): bool;
}
