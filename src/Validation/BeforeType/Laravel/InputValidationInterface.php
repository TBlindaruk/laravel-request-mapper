<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel;

/**
 * Interface InputValidationInterface
 *
 * @package Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel
 */
interface InputValidationInterface
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
