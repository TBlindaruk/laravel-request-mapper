<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\Validation\Data;

use Maksi\LaravelRequestMapper\Filling\RequestData\RequestData;

/**
 * Class ValidateData
 *
 * @package Maksi\LaravelRequestMapper\Validation\Data
 */
class ValidateData
{
    /**
     * @var RequestData
     */
    private $object;

    /**
     * @var array
     */
    private $fillData;

    /**
     * BeforeFillingEvent constructor.
     *
     * @param RequestData $object
     * @param array       $fillData
     */
    public function __construct(RequestData $object, array $fillData)
    {
        $this->object = $object;
        $this->fillData = $fillData;
    }

    /**
     * @return array
     */
    public function getFillData(): array
    {
        return $this->fillData;
    }

    /**
     * @return RequestData
     */
    public function getObject(): RequestData
    {
        return $this->object;
    }
}
