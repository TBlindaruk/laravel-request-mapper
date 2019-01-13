<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub;

use Maksi\LaravelRequestMapper\Validation\LaravelValidator\AbstractValidationRule;

/**
 * Class ValidatorRule
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub
 */
class ValidatorRule extends AbstractValidationRule
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
