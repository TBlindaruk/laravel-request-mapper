<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\Annotation;

use Doctrine\Common\Annotations\Reader;
use Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\Annotation\ValidationClass;
use ReflectionClass;

/**
 * Class Resolver
 *
 * @package Maksi\LaravelRequestMapper\Validation\Annotation
 */
class Resolver implements ResolverInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var array[]
     */
    private $annotations = [];

    /**
     * @var array
     */
    private $reflections;

    /**
     * Resolver constructor.
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param object $object
     *
     * @return bool
     * @throws \ReflectionException
     */
    final public function isNoValidationTypeDetermined($object): bool
    {
        /** @var Type|null $annotationClass */
        $annotationClass = $this->getClassAnnotation(\get_class($object), Type::class);

        return null === $annotationClass;
    }

    /**
     * @param $object
     *
     * @return bool
     * @throws \ReflectionException
     */
    final public function isLaravelValidation($object): bool
    {
        /** @var Type|null $annotationClass */
        $annotationClass = $this->getClassAnnotation(\get_class($object), Type::class);
        if (null === $annotationClass) {
            return false;
        }

        return $annotationClass->isLaravel();
    }

    /**
     * @param $object
     *
     * @return bool
     * @throws \ReflectionException
     */
    final public function isAnnotationValidation($object): bool
    {
        /** @var Type|null $annotationClass */
        $annotationClass = $this->getClassAnnotation(\get_class($object), Type::class);
        if (null === $annotationClass) {
            return false;
        }

        return $annotationClass->isAnnotation();
    }

    /**
     * @param $object
     *
     * @return null|string
     * @throws \ReflectionException
     */
    final public function getLaravelValidationClassName($object): ?string
    {
        /** @var ValidationClass|null $annotationClass */
        $annotationClass = $this->getClassAnnotation(\get_class($object), ValidationClass::class);
        if (null === $annotationClass) {
            return null;
        }

        return $annotationClass->class;
    }

    /**
     * @param string $className
     * @param string $annotationType
     *
     * @return object
     * @throws \ReflectionException
     */
    final protected function getClassAnnotation(string $className, string $annotationType)
    {
        if (!isset($this->annotations[$className])) {
            $this->annotations[$className] = [];
        }
        if (!isset($this->annotations[$className][$annotationType])) {
            $reflectionClass = $this->getReflectionClass($className);
            $this->annotations[$className][$annotationType] = $this->reader->getClassAnnotation(
                $reflectionClass,
                $annotationType
            );
        }

        return $this->annotations[$className][$annotationType];
    }

    /**
     * @param string $className
     *
     * @return ReflectionClass
     * @throws \ReflectionException
     */
    private function getReflectionClass(string $className): ReflectionClass
    {
        if (!isset($this->reflections[$className])) {
            $this->reflections[$className] = new ReflectionClass($className);
        }

        return $this->reflections[$className];
    }
}
