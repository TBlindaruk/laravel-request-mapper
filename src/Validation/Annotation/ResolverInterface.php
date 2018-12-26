<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\Annotation;

/**
 * Interface ResolverInterface
 *
 * @package Maksi\LaravelRequestMapper\Validation\Annotation
 */
interface ResolverInterface
{
    /**
     * Check if DTO object has validation type.
     *
     * @param object $object
     *
     * @return bool
     */
    public function isNoValidationTypeDetermined($object): bool;

    /**
     * Check if DTO object should be validated by Laravel validation.
     *
     * @param object $object
     *
     * @return bool
     */
    public function isLaravelValidation($object): bool;

    /**
     * Check if DTO object should be validated by Symfony annotation validation.
     *
     * @param object $object
     *
     * @return bool
     */
    public function isAnnotationValidation($object): bool;

    /**
     * Return class where we should get the rules for the laravel validation.
     *
     * @param object $object
     *
     * @return null|string
     */
    public function getLaravelValidationClassName($object): ?string;
}
