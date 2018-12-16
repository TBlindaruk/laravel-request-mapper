<?php
declare(strict_types = 1);

namespace Tests\Integration\Stub;

use Maksi\RequestMapperL\DataTransferObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RequestDataTransferObject
 *
 * @package Tests\Integration
 */
class RequestDataTransferObject extends DataTransferObject
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