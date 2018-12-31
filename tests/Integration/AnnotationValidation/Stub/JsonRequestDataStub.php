<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\JsonRequestData;
use Maksi\LaravelRequestMapper\Validation\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class JsonRequestDataStub
 *
 * @Type(type="annotation")
 * @package Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation\Stub
 */
class JsonRequestDataStub extends JsonRequestData
{
    /**
     * @Assert\Type(type="int")
     * @Assert\NotBlank()
     */
    private $jsonAge;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $jsonTitle;

    /**
     * @param array $data
     */
    protected function init(array $data): void
    {
        $this->jsonAge = $data['age'] ?? null;
        $this->jsonTitle = $data['title'] ?? null;
    }

    /**
     * @return string
     */
    public function getJsonTitle(): string
    {
        return $this->jsonTitle;
    }

    /**
     * @return int
     */
    public function getJsonAge(): int
    {
        return $this->jsonAge;
    }
}
