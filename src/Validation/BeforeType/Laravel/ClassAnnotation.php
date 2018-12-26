<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel;

/**
 * Class ClassAnnotation
 *
 * @package Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel
 * @Annotation
 */
final class ClassAnnotation
{
    /**
     * @var string
     */
    private $class;

    /**
     * LaravelClass constructor.
     *
     * @param array $options
     *
     * @throws \ReflectionException
     */
    public function __construct(array $options)
    {
        $class = $options['class'] ?? null;
        if (null === $class || !\is_string($class)) {
            throw new \InvalidArgumentException('Property "class" is required');
        }
        $reflectionClass = new \ReflectionClass($class);

        if (!$reflectionClass->implementsInterface(InputValidationInterface::class)) {
            throw new \InvalidArgumentException('Given class should implement ' . InputValidationInterface::class);
        }
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}
