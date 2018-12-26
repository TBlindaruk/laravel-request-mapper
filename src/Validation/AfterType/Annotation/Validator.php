<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\AfterType\Annotation;

use Maksi\LaravelRequestMapper\Validation\Annotation\ResolverInterface;
use Maksi\LaravelRequestMapper\Validation\Data\ErrorCollection;
use Maksi\LaravelRequestMapper\Validation\Data\ErrorData;
use Maksi\LaravelRequestMapper\Validation\Data\ValidateData;
use Maksi\LaravelRequestMapper\Validation\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidatorInterface;

/**
 * Class Validator
 *
 * @package Maksi\LaravelRequestMapper\Validation\AfterType\Annotation
 */
class Validator implements ValidatorInterface
{
    /**
     * @var ResolverInterface
     */
    private $resolver;

    /**
     * @var SymfonyValidatorInterface
     */
    private $validator;

    /**
     * AnnotationValidator constructor.
     *
     * @param ResolverInterface         $resolver
     * @param SymfonyValidatorInterface $validator
     */
    public function __construct(ResolverInterface $resolver, SymfonyValidatorInterface $validator)
    {
        $this->resolver = $resolver;
        $this->validator = $validator;
    }

    /**
     * @param ValidateData $validateData
     *
     * @return ErrorCollection
     */
    public function validate(ValidateData $validateData): ErrorCollection
    {
        $errors = $this->validator->validate($validateData->getObject());

        if ($errors->count() === 0) {
            return new ErrorCollection();
        }

        $collection = new ErrorCollection();

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $collection->push(
                new ErrorData($error->getMessage(), $error->getPropertyPath())
            );
        }

        return $collection;
    }

    /**
     * @param ValidateData $validateData
     *
     * @return bool
     */
    public function support(ValidateData $validateData): bool
    {
        $object = $validateData->getObject();

        return $this->resolver->isAnnotationValidation($object);
    }
}
