<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\Stub;

use Maksi\LaravelRequestMapper\RequestData\AllRequestData;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AllRequestDataStub
 *
 * @package Maksi\LaravelRequestMapper\Tests\Integration\Stub
 */
class AllRequestDataStub extends AllRequestData
{
    /**
     * @Assert\Type(type="int")
     * @Assert\NotBlank()
     */
    private $age;

    /**
     * @var string
     * @Assert\NotBlank()
     */
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