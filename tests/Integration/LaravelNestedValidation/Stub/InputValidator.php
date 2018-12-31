<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub;

use Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\AbstractInputValidation;

/**
 * Class InputValidator
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub
 */
class InputValidator extends AbstractInputValidation
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nested' => 'array|required',
            'title' => 'string|required',
            'nested.title' => 'string|required',
        ];
    }
}
