<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel;

/**
 * Interface ValidationRuleInterface
 *
 * @package Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel
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
