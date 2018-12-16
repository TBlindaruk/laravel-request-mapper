<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL\MappingStrategies;

use Illuminate\Http\Request;
use Maksi\RequestMapperL\RequestData\AllRequestData;
use Maksi\RequestMapperL\RequestData\RequestData;

/**
 * Class AllStrategy
 *
 * @package Maksi\RequestMapperL\MappingStrategies
 */
class AllStrategy implements StrategyInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * AllStrategy constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param RequestData $object
     *
     * @return array
     */
    public function resolve(RequestData $object): array
    {
        return $this->request->all();
    }

    /**
     * @param RequestData $object
     *
     * @return bool
     */
    public function support(RequestData $object): bool
    {
        return $object instanceof AllRequestData;
    }
}
