<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\JsonRequestData;

/**
 * Class NestedRequestDataStub
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub
 */
class NestedRequestDataStub extends JsonRequestData
{
    private $nestedTitle;

    /**
     * @param array $data
     */
    protected function init(array $data): void
    {
        $this->nestedTitle = $data['title'] ?? null;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->nestedTitle;
    }
}
