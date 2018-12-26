<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation;

use Illuminate\Contracts\Config\Repository as Config;
use LogicException;
use Maksi\LaravelRequestMapper\Validation\Data\ValidateData;
use Maksi\LaravelRequestMapper\Validation\ResponseException\AbstractException;
use Maksi\LaravelRequestMapper\Validation\ResponseException\JsonResponsableException;

/**
 * TODO: add unit tests
 *
 * Class ValidationProcessor
 *
 * @package Maksi\LaravelRequestMapper\Validation
 */
class ValidationProcessor
{
    private const CONFIG_EXCEPTION_STRING = 'laravel-request-mapper.exception-class';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var ValidatorInterface[]
     */
    private $beforeHandlers = [];

    /**
     * @var ValidatorInterface[]
     */
    private $afterHandlers = [];

    /**
     * ValidationProcessor constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param ValidatorInterface $handler
     *
     * @return ValidationProcessor
     */
    public function addBeforeFillingHandler(ValidatorInterface $handler): self
    {
        $this->beforeHandlers[] = $handler;

        return $this;
    }

    /**
     * @param ValidatorInterface $handler
     *
     * @return ValidationProcessor
     */
    public function addAfterFillingHandler(ValidatorInterface $handler): self
    {
        $this->afterHandlers[] = $handler;

        return $this;
    }

    /**
     * @param ValidateData $data
     *
     * @throws AbstractException
     */
    public function validateBeforeFilling(ValidateData $data): void
    {
        $this->runValidateHandlers($this->beforeHandlers, $data);
    }

    /**
     * @param ValidateData $data
     *
     * @throws AbstractException
     */
    public function validateAfterFilling(ValidateData $data): void
    {
        $this->runValidateHandlers($this->afterHandlers, $data);
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

    /**
     * @param ValidatorInterface[] $handlers
     * @param ValidateData         $data
     *
     * @throws AbstractException
     */
    protected function runValidateHandlers(array $handlers, ValidateData $data): void
    {
        foreach ($handlers as $handler) {
            if ($handler->support($data)) {
                $errors = $handler->validate($data);
                if ($errors->isInvalid()) {
                    $exception = $this->getExceptionClass();
                    $exception->setErrorCollection($errors);

                    throw $exception;
                }

                return;
            }
        }
    }
}
