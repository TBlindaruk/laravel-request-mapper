<?php
declare(strict_types = 1);

namespace Tests\Integration\Stub;

use Maksi\RequestMapperL\DataTransferObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ValidCustomObject
 *
 * @package Tests\Integration\Stub
 */
class ValidCustomObject extends DataTransferObject
{
    /**
     * @var array
     * @Assert\Type(type="array")
     * @Assert\NotBlank()
     */
    private $userAgent;

    /**
     * @param array $data
     */
    protected function init(array $data): void
    {
        $this->userAgent = $data['user-agent'] ?? null;
    }

    /**
     * @return array
     */
    public function getUserAgent(): array
    {
        return $this->userAgent;
    }
}