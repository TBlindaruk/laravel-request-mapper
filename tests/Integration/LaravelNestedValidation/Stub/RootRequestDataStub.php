<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\JsonRequestData;
use Maksi\LaravelRequestMapper\Validation\Annotation\ValidationRules;

/**
 * Class RootRequestDataStub
 * @ValidationRules(class="\Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub\ValidatorRule")
 * @package Maksi\LaravelRequestMapper\Tests\Integration\LaravelNestedValidation\Stub
 */
class RootRequestDataStub extends JsonRequestData
{
    private $title;

    private $nested;

    /**
     * @param array $data
     */
    protected function init(array $data): void
    {
        $this->title = $data['title'] ?? null;
        $this->nested = new NestedRequestDataStub($data['nested'] ?? []);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return NestedRequestDataStub
     */
    public function getNested(): NestedRequestDataStub
    {
        return $this->nested;
    }
}
