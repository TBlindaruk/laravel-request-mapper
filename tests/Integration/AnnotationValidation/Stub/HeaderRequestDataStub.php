<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\HeaderRequestData;
use Maksi\LaravelRequestMapper\Validation\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class HeaderRequestDataStub
 *
 * @Type(type="annotation")
 * @package Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation\Stub
 */
class HeaderRequestDataStub extends HeaderRequestData
{
    /**
     * @Assert\Type(type="array")
     * @Assert\NotBlank()
     */
    private $headerAge;

    /**
     * @var array
     * @Assert\NotBlank()
     */
    private $headerTitle;

    /**
     * @param array $data
     */
    protected function init(array $data): void
    {
        $this->headerAge = $data['age'] ?? null;
        $this->headerTitle = $data['title'] ?? null;
    }

    /**
     * @return array
     */
    public function getHeaderTitle(): array
    {
        return $this->headerTitle;
    }

    /**
     * @return array
     */
    public function getHeaderAge(): array
    {
        return $this->headerAge;
    }
}
