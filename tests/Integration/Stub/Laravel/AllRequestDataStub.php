<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\Stub\Laravel;

use Maksi\LaravelRequestMapper\Filling\RequestData\AllRequestData;
use Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\ClassAnnotation;

/**
 * Class AllRequestDataStub
 *
 * @ClassAnnotation(class="\Maksi\LaravelRequestMapper\Tests\Integration\Stub\Laravel\InputValidator")
 * @package Maksi\LaravelRequestMapper\Tests\Integration\Stub
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
