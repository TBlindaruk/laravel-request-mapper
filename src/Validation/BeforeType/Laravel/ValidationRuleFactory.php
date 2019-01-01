<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel;

use Illuminate\Contracts\Container\Container;

/**
 * Class ValidationRuleFactory
 *
 * @package Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel
 */
class ValidationRuleFactory
{
    /**
     * @var Container
     */
    private $container;

    /**
     * InputValidationFactory constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $inputValidation
     *
     * @return ValidationRuleInterface
     */
    public function make(string $inputValidation): ValidationRuleInterface
    {
        $object = $this->container->make($inputValidation);

        if (!$object instanceof ValidationRuleInterface) {
            throw new ValidationRuleTypeException('$object should be instance of ' . ValidationRuleInterface::class);
        }

        return $object;
    }
}
