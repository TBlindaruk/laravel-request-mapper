<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Unit\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\JsonRequestData;

/**
 * Class JsonRequestDataStub
 *
 * @package Maksi\LaravelRequestMapper\Tests\Unit\Stub
 */
class JsonRequestDataStub extends JsonRequestData
{
    private $age;

    private $title;

    /**
     * @param array $data
     */
    protected function init(array $data): void
    {
        $this->age = $data['age'] ?? null;
        $this->title = $data['title'] ?? null;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }
}
