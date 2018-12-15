<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL\Support;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Maksi\RequestMapperL\RequestMapperResolver;

/**
 * Class RequestMapperServiceProvider
 *
 * @package Maksi\RequestMapperL\Support
 */
abstract class RequestMapperServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    final public function register(): void
    {
        $this->bindResolver();
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
