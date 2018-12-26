<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\Data;

/**
 * Class ErrorData
 *
 * @package Maksi\LaravelRequestMapper\Validation\Data
 */
class ErrorData
{
    /**
     * @var null|string
     */
    private $message;

    /**
     * @var null|string
     */
    private $property;

    /**
     * ErrorData constructor.
     *
     * @param null|string $message
     * @param null|string $property
     */
    public function __construct(?string $message, ?string $property)
    {
        $this->message = $message;
        $this->property = $property;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return null|string
     */
    public function getProperty(): ?string
    {
        return $this->property;
    }
}
