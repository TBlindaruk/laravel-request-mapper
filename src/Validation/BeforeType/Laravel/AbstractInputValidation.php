<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel;

/**
 * Class AbstractInputValidation
 *
 * @package Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel
 */
abstract class AbstractInputValidation implements InputValidationInterface
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
