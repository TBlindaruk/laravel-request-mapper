<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel;

/**
 * Class AbstractValidationRule
 *
 * @package Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel
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
