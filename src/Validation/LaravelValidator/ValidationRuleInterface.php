<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\LaravelValidator;

/**
 * Interface ValidationRuleInterface
 *
 * @package Maksi\LaravelRequestMapper\Validation\LaravelValidator
 */
interface ValidationRuleInterface
{
    /**
     * @return array
     */
    public function rules(): array;

    /**
     * @return array
     */
    public function messages(): array;

    /**
     * @return array
     */
    public function customAttributes(): array;
}
