<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper\MappingStrategies;

use Illuminate\Http\Request;
use Maksi\LaravelRequestMapper\RequestData\RequestData;
use Maksi\LaravelRequestMapper\RequestData\JsonRequestData;

/**
 * Class JsonStrategy
 *
 * @package Maksi\RequestMapperL\MappingStrategies
 */
class JsonStrategy implements StrategyInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * JsonAllStrategy constructor.
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
        return $this->request->json()->all();
    }

    /**
     * @param RequestData $object
     *
     * @return bool
     */
    public function support(RequestData $object): bool
    {
        return $object instanceof JsonRequestData;
    }
}
