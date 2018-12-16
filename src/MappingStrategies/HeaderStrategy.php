<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL\MappingStrategies;

use Illuminate\Http\Request;
use Maksi\RequestMapperL\RequestData\RequestData;
use Maksi\RequestMapperL\RequestData\HeaderRequestData;

/**
 * Class HeaderStrategy
 *
 * @package Maksi\RequestMapperL\MappingStrategies
 */
class HeaderStrategy implements StrategyInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * AllHeaderStrategy constructor.
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
        return $this->request->headers->all();
    }

    /**
     * @param RequestData $object
     *
     * @return bool
     */
    public function support(RequestData $object): bool
    {
        return $object instanceof HeaderRequestData;
    }
}