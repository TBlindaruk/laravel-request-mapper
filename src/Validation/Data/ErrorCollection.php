<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\Data;

use Illuminate\Support\Collection;

/**
 * Class ErrorCollection
 *
 * @package Maksi\LaravelRequestMapper\Validation\Data
 */
class ErrorCollection
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * ErrorCollection constructor.
     */
    public function __construct()
    {
        $this->collection = new Collection();
    }

    /**
     * @param ErrorData $errorData
     *
     * @return ErrorCollection
     */
    public function push(ErrorData $errorData): self
    {
        $this->collection->push($errorData);

        return $this;
    }

    /**
     * @return ErrorData[]
     */
    public function all(): array
    {
        return $this->collection->all();
    }

    /**
     * @return bool
     */
    public function isInvalid(): bool
    {
        return $this->collection->isNotEmpty();
    }
}
