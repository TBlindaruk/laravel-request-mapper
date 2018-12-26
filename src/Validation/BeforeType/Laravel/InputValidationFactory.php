<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel;

use Illuminate\Contracts\Container\Container;

/**
 * Class InputValidationFactory
 *
 * @package Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel
 */
class InputValidationFactory
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
     * @return InputValidationInterface
     */
    public function make(string $inputValidation): InputValidationInterface
    {
        $object = $this->container->make($inputValidation);

        if (!$object instanceof InputValidationInterface) {
            //TODO: change exception
            throw new \InvalidArgumentException();
        }

        return $object;
    }
}
