<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL;

use Doctrine\Common\Annotations\AnnotationRegistry;
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
        $this->singletonStorage();
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
     * @return void
     */
    protected function singletonStorage(): void
    {
        $this->app->singleton(Storage::class, Storage::class);
    }

    /**
     * @return void
     */
    protected function resolveDataTransferObject(): void
    {
        $this->app->resolving(function ($object) {
            if ($object instanceof DataTransferObject) {

                /** @var Resolver $resolving */
                $resolving = $this->app->make(Resolver::class);
                $resolving->resolve($object);
            }

            return $object;
        });
    }
}
