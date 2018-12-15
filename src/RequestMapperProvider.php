<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Validator\ContainerConstraintValidatorFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

/**
 * Class RequestMapperProvider
 *
 * @package Maksi\RequestMapperL
 */
abstract class RequestMapperProvider extends ServiceProvider
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
        $this->bindValidatorInterface();
        $this->bindResolver();
    }

    protected function bindValidatorInterface(): void
    {
        $this->app->singleton(ValidatorInterface::class, function () {
            return (new ValidatorBuilder())
                ->setConstraintValidatorFactory(new ContainerConstraintValidatorFactory($this->app))
                ->enableAnnotationMapping()
                ->getValidator();
        });
    }

    protected function bindResolver(): void
    {
        /** @var RequestMapperResolver $resolver */
        $resolver = $this->app->make(RequestMapperResolver::class);
        /** @var Request $request */
        $request = $this->app->make(Request::class);
        $resolver->map($this->resolveMap($request));
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    abstract protected function resolveMap(Request $request): array;
}
