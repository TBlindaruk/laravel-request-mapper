<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\LaravelValidation\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\AllRequestData;
use Maksi\LaravelRequestMapper\Validation\Annotation\ValidationRules;

/**
 * Class AllRequestDataStub
 * @ValidationRules(class="\Maksi\LaravelRequestMapper\Tests\Integration\LaravelValidation\Stub\ValidatorRule")
 * @package Maksi\LaravelRequestMapper\Tests\Integration\LaravelValidation\Stub
 */
class AllRequestDataStub extends AllRequestData
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
