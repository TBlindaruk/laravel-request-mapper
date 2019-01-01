<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelValidation\Stub;

use Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\AbstractValidationRule;

/**
 * Class ValidatorRule
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration\LaravelValidation\Stub
 */
class ValidatorRule extends AbstractValidationRule
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'age' => 'integer|required',
            'title' => 'string|required',
        ];
    }
}
