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
     * Return class where we should get the rules for the laravel validation.
     *
     * @param object $object
     *
     * @return null|string
     */
    public function getLaravelValidationClassName($object): ?string;
}
