<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL;

use Illuminate\Http\Request;
use Maksi\RequestMapperL\Exception\RequestMapperException;

/**
 * Class Resolver
 *
 * @package Maksi\RequestMapperL
 */
class Resolver
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * ResolvingStrategy constructor.
     *
     * @param Storage   $storage
     * @param Request   $request
     * @param Validator $validator
     */
    public function __construct(Storage $storage, Request $request, Validator $validator)
    {
        $this->storage = $storage;
        $this->request = $request;
        $this->validator = $validator;
    }

    /**
     * @param $object
     *
     * @throws Exception\AbstractException
     * @throws RequestMapperException
     */
    public function resolve(DataTransferObject $object): void
    {
        $registererClass = $this->storage->getRegisterClass();
        $objectName = \get_class($object);
        if (!\in_array($objectName, $registererClass, true)) {
            $data = $this->request->all();
        } else {
            $map = $this->storage->getMap();
            $data = $map[$objectName];
        }

        $object->__construct($data);
        $this->validator->applyAfterResolvingValidation($object);
    }
}
