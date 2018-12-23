<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper;

use Illuminate\Contracts\Config\Repository as Config;
use Maksi\LaravelRequestMapper\ValidationException\AbstractException;
use Maksi\LaravelRequestMapper\ValidationException\JsonResponsableException;
use Symfony\Component\Validator\Exception\LogicException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Validator
 *
 * @package Maksi\LaravelRequestMapper
 */
class Validator
{
    private const CONFIG_EXCEPTION_STRING = 'laravel-request-mapper.exception-class';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * RequestMapperResolver constructor.
     *
     * @param Config             $config
     * @param ValidatorInterface $validator
     */
    public function __construct(Config $config, ValidatorInterface $validator)
    {
        $this->config = $config;
        $this->validator = $validator;
    }

    /**
     * @param $resolved
     *
     * @throws AbstractException
     */
    public function applyAfterResolvingValidation($resolved): void
    {
        $errors = $this->validator->validate($resolved);
        if ($errors->count() > 0) {
            $exception = $this->getExceptionClass();
            //TODO: Should be unit test, that this method is called
            $exception->setConstraintViolationList($errors);
            throw $exception;
        }
    }

    /**
     * @return AbstractException
     */
    protected function getExceptionClass(): AbstractException
    {
        $class = new JsonResponsableException();
        $className = $this->config->get(self::CONFIG_EXCEPTION_STRING);

        if ($className) {
            $class = new $className;
        }

        if (!$class instanceof AbstractException) {
            throw  new LogicException('$class should be instance of ' . AbstractException::class);
        }

        return $class;
    }
}
