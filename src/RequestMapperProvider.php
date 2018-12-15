<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Maksi\RequestMapperL\Exception\AbstractException;
use Maksi\RequestMapperL\Exception\RequestMapperException;
use Symfony\Component\Validator\ContainerConstraintValidatorFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

/**
 * Class RequestMapperProvider
 *
 * @package Maksi\RequestMapperL
 */
class RequestMapperProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        AnnotationRegistry::registerLoader('class_exists');
    }

    /**
     * @return void
     */
    final public function register(): void
    {
        $this->singletonResolver();
        $this->bindValidatorInterface();
        $this->bindException();
        $this->resolveDataTransferObject();
    }

    /**
     * @return void
     */
    protected function bindValidatorInterface(): void
    {
        $this->app->singleton(ValidatorInterface::class, function () {
            return (new ValidatorBuilder())
                ->setConstraintValidatorFactory(new ContainerConstraintValidatorFactory($this->app))
                ->enableAnnotationMapping()
                ->getValidator();
        });
    }

    /**
     * @return void
     */
    protected function bindException(): void
    {
        $this->app->bind(AbstractException::class, RequestMapperException::class);
    }

    /**
     *
     */
    protected function singletonResolver(): void
    {
        $this->app->singleton(RequestMapperResolver::class, RequestMapperResolver::class);
    }

    /**
     * @return void
     */
    protected function resolveDataTransferObject(): void
    {
        $this->app->resolving(function ($object, Container $container) {
            if ($object instanceof DataTransferObject) {

                /** @var RequestMapperResolver $resolver */
                $resolver = $this->app->make(RequestMapperResolver::class);
                $registererClass = $resolver->getRegisterClass();

                if (!\in_array(\get_class($object), $registererClass, true)) {
                    /** @var Request $request */
                    $request = $container->make(Request::class);

                    $object->__construct($request->all());
                    $resolver->applyAfterResolvingValidation($object);
                }
            }

            return $object;
        });
    }
}
