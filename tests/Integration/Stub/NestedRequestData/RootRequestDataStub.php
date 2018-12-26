<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\Stub\NestedRequestData;

use Maksi\LaravelRequestMapper\Filling\RequestData\JsonRequestData;
use Maksi\LaravelRequestMapper\Validation\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RootRequestDataStub
 *
 * @Type(type="annotation")
 * @package Maksi\LaravelRequestMapper\Tests\Integration\Stub\NestedRequestData
 */
class RootRequestDataStub extends JsonRequestData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $title;

    /**
     * @Assert\Valid()
     */
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
