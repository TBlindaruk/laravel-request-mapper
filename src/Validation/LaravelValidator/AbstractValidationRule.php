<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\LaravelValidator;

/**
 * Class AbstractValidationRule
 *
 * @package Maksi\LaravelRequestMapper\Validation\LaravelValidator
 */
abstract class AbstractValidationRule implements ValidationRuleInterface
{
    /**
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function customAttributes(): array
    {
        return [];
    }
}
