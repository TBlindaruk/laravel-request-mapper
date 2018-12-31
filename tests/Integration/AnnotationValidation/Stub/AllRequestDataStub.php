<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation\Stub;

use Maksi\LaravelRequestMapper\Filling\RequestData\AllRequestData;
use Maksi\LaravelRequestMapper\Validation\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AllRequestDataStub
 *
 * @Type(type="annotation")
 * @package Maksi\LaravelRequestMapper\Tests\Integration\AnnotationValidation\Stub
 */
class AllRequestDataStub extends AllRequestData
{
    /**
     * @Assert\Type(type="int")
     * @Assert\NotBlank()
     */
    private $allAge;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $allTitle;

    /**
     * @param array $data
     */
    protected function init(array $data): void
    {
        $this->allAge = $data['age'] ?? null;
        $this->allTitle = $data['title'] ?? null;
    }

    /**
     * @return string
     */
    public function getAllTitle(): string
    {
        return $this->allTitle;
    }

    /**
     * @return int
     */
    public function getAllAge(): int
    {
        return $this->allAge;
    }
}
