<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\ServiceProvider;
use Maksi\LaravelRequestMapper\Exception\AbstractException;
use Maksi\LaravelRequestMapper\Exception\RequestMapperException;
use Maksi\LaravelRequestMapper\MappingStrategies\AllStrategy;
use Maksi\LaravelRequestMapper\MappingStrategies\HeaderStrategy;
use Maksi\LaravelRequestMapper\MappingStrategies\JsonStrategy;
use Maksi\LaravelRequestMapper\RequestData\RequestData;
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
     * @param StrategiesHandler $strategiesHandler
     */
    public function boot(StrategiesHandler $strategiesHandler): void
    {
        AnnotationRegistry::registerLoader('class_exists');

        $strategiesHandler
            ->addStrategy($this->app->make(AllStrategy::class))
            ->addStrategy($this->app->make(JsonStrategy::class))
            ->addStrategy($this->app->make(HeaderStrategy::class));
    }

    /**
     * @return void
     */
    final public function register(): void
    {
        $this->bindValidatorInterface();
        $this->bindException();
        $this->singletonHandler();
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
    protected function singletonHandler(): void
    {
        $this->app->singleton(StrategiesHandler::class);
    }

    /**
     * @return void
     */
    protected function resolveDataTransferObject(): void
    {
        $this->app->resolving(function ($object) {
            if ($object instanceof RequestData) {

                /** @var StrategiesHandler $handler */
                $handler = $this->app->make(StrategiesHandler::class);
                $handler->handle($object);

                /** @var Validator $validator */
                $validator = $this->app->make(Validator::class);
                $validator->applyAfterResolvingValidation($object);
            }

            return $object;
        });
    }
}
