<?php
declare(strict_types = 1);

namespace Tests\Integration\Stub;

use Maksi\RequestMapperL\DataTransferObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class InvalidCustomObject
 *
 * @package Tests\Integration\Stub
 */
class InvalidCustomObject extends DataTransferObject
{
    /**
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @param array $data
     */
    protected function init(array $data): void
    {
        $this->name = $data['name'] ?? null;
    }
}
