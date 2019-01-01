<?php
declare(strict_types = 1);

namespace Maksi\LaravelRequestMapper;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use Illuminate\Support\ServiceProvider;
use Maksi\LaravelRequestMapper\Filling\RequestData\RequestData;
use Maksi\LaravelRequestMapper\Filling\Strategies\AllStrategy;
use Maksi\LaravelRequestMapper\Filling\Strategies\HeaderStrategy;
use Maksi\LaravelRequestMapper\Filling\Strategies\JsonStrategy;
use Maksi\LaravelRequestMapper\Validation\AfterType\Annotation\Validator as AfterAnnotationValidator;
use Maksi\LaravelRequestMapper\Validation\Annotation\Resolver;
use Maksi\LaravelRequestMapper\Validation\Annotation\ResolverInterface;
use Maksi\LaravelRequestMapper\Validation\BeforeType\Laravel\Validator as BeforeLaravelValidator;
use Maksi\LaravelRequestMapper\Validation\ValidationProcessor;
use Symfony\Component\Validator\ContainerConstraintValidatorFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

/**
 * Class RequestMapperProvider
 *
 * @package Maksi\LaravelRequestMapper
 */
class RequestMapperProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @var ValidationProcessor $validationProcessor */
        $validationProcessor = $this->app->make(ValidationProcessor::class);
        /** @var FillingChainProcessor $fillingChainProcessor */
        $fillingChainProcessor = $this->app->make(FillingChainProcessor::class);
        AnnotationRegistry::registerLoader('class_exists');

        $fillingChainProcessor
            ->addStrategy($this->app->make(AllStrategy::class))
            ->addStrategy($this->app->make(JsonStrategy::class))
            ->addStrategy($this->app->make(HeaderStrategy::class));

        $validationProcessor
            ->addBeforeFillingHandler($this->app->make(BeforeLaravelValidator::class))
            ->addAfterFillingHandler($this->app->make(AfterAnnotationValidator::class));
    }

    /**
     * @return void
     */
    final public function register(): void
    {
        $this->bindValidatorInterface();
        $this->bindAnnotationResolverInterface();

        $this->singletonFillingChainProcessor();
        $this->singletonValidationProcessor();

        $this->contextualBindingForReaderInResolver();

        $this->resolveRequestDataObject();
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
    public function bindAnnotationResolverInterface(): void
    {
        $this->app->bind(ResolverInterface::class, Resolver::class);
    }

    /**
     * @return void
     */
    protected function singletonFillingChainProcessor(): void
    {
        $this->app->singleton(FillingChainProcessor::class);
    }

    /**
     * @return void
     */
    private function singletonValidationProcessor(): void
    {
        $this->app->singleton(ValidationProcessor::class);
    }

    /**
     * @return void
     */
    protected function contextualBindingForReaderInResolver(): void
    {
        $this->app->when(Resolver::class)->needs(Reader::class)->give(AnnotationReader::class);
    }

    /**
     * @return void
     */
    protected function resolveRequestDataObject(): void
    {
        $this->app->resolving(function ($object) {
            if ($object instanceof RequestData) {
                /** @var FillingChainProcessor $fillingChainProcessor */
                $fillingChainProcessor = $this->app->make(FillingChainProcessor::class);
                $fillingChainProcessor->handle($object);
            }

            return $object;
        });
    }
}
