<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL;

use Illuminate\Contracts\Container\Container;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestMapperResolver
 *
 * @package Maksi\RequestMapperL
 */
class RequestMapperResolver
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * RequestMapper constructor.
     *
     * @param Container          $container
     * @param ValidatorInterface $validator
     */
    public function __construct(Container $container, ValidatorInterface $validator)
    {
        $this->container = $container;
        $this->validator = $validator;
    }
    
    /**
     * @param array $map
     */
    public function map(array $map): void
    {
        foreach ($map as $className => $arguments) {
            $this->container->singleton($className, function () use ($className, $arguments) {
                return new $className(... $arguments);
            });
            
            $this->container->afterResolving($className, function ($resolved){
                $errors = $this->validator->validate($resolved);
                if($errors->count() > 0){
                    throw new RequestMapperException($errors);
                }
            });
        }
    }
}
