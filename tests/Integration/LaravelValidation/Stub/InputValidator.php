<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelValidation\Stub;

use Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\AbstractInputValidation;

/**
 * Class InputValidator
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration\LaravelValidation\Stub
 */
class InputValidator extends AbstractInputValidation
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
