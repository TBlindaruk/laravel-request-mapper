<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\LaravelValidator;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Validation\ValidationException;
use Maksi\LaravelRequestMapper\Validation\Annotation\ResolverInterface;
use Maksi\LaravelRequestMapper\Validation\Data\ErrorCollection;
use Maksi\LaravelRequestMapper\Validation\Data\ErrorData;
use Maksi\LaravelRequestMapper\Validation\Data\ValidateData;
use Maksi\LaravelRequestMapper\Validation\ValidatorInterface;

/**
 * Class Validator
 *
 * @package Maksi\LaravelRequestMapper\Validation\LaravelValidator
 */
class Validator implements ValidatorInterface
{
    /**
     * @var ResolverInterface
     */
    private $resolver;

    /**
     * @var ValidationFactory
     */
    private $validationFactory;

    /**
     * @var ValidationRuleFactory
     */
    private $validationRuleFactory;

    /**
     * LaravelValidationValidator constructor.
     *
     * @param ResolverInterface     $resolver
     * @param ValidationFactory     $validationFactory
     * @param ValidationRuleFactory $validationRuleFactory
     */
    public function __construct(
        ResolverInterface $resolver,
        ValidationFactory $validationFactory,
        ValidationRuleFactory $validationRuleFactory
    ) {
        $this->resolver = $resolver;
        $this->validationFactory = $validationFactory;
        $this->validationRuleFactory = $validationRuleFactory;
    }

    /**
     * @param ValidateData $validateData
     *
     * @return ErrorCollection
     */
    public function validate(ValidateData $validateData): ErrorCollection
    {
        $data = $validateData->getFillData();

        $validationClassName = $this->resolver->getLaravelValidationClassName($validateData->getObject());
        $validationRule = $this->validationRuleFactory->make($validationClassName);

        $validator = $this->validationFactory->make(
            $data,
            $validationRule->rules(),
            $validationRule->messages(),
            $validationRule->customAttributes()
        );

        $errorCollection = new ErrorCollection();

        try {
            $validator->validate();
        } catch (ValidationException $validationException) {
            foreach ($validator->errors()->messages() as $field => $messages) {
                foreach ($messages as $message) {
                    $errorCollection->push(new ErrorData($message, $field));
                }
            }
        }

        return $errorCollection;
    }

    /**
     * @param ValidateData $validateData
     *
     * @return bool
     */
    public function support(ValidateData $validateData): bool
    {
        $validationClass = $this->resolver->getLaravelValidationClassName($validateData->getObject());

        return null !== $validationClass;
    }
}
