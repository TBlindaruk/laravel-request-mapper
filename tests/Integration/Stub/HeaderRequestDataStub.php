<?php
declare(strict_types = 1);

namespace Tests\Integration\Stub;

use Maksi\LaravelRequestMapper\RequestData\HeaderRequestData;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class HeaderRequestDataStub
 *
 * @package Tests\Integration\Stub
 */
class HeaderRequestDataStub extends HeaderRequestData
{
    /**
     * @Assert\Type(type="array")
     * @Assert\NotBlank()
     */
    private $age;

    /**
     * @var array
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
     * @return array
     */
    public function getTitle(): array
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getAge(): array
    {
        return $this->age;
    }
}