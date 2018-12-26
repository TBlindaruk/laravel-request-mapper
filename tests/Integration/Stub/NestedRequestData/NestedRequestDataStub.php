<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Tests\Integration\Stub\NestedRequestData;

use Maksi\LaravelRequestMapper\Filling\RequestData\JsonRequestData;
use Maksi\LaravelRequestMapper\Validation\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class NestedRequestDataStub
 *
 * @Type(type="annotation")
 * @package Maksi\LaravelRequestMapper\Tests\Integration\Stub\NestedRequestData
 */
class NestedRequestDataStub extends JsonRequestData
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $nestedTitle;

    /**
     * @param array $data
     */
    protected function init(array $data): void
    {
        $this->nestedTitle = $data['title'] ?? null;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->nestedTitle;
    }
}
