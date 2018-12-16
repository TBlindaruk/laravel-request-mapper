<?php
declare(strict_types = 1);

namespace Maksi\RequestMapperL\Support;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Maksi\RequestMapperL\Storage;

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
    final public function boot(): void
    {
        $this->bootResolver();
    }

    /**
     * @return void
     */
    protected function bootResolver(): void
    {
        /** @var Storage $resolver */
        $resolver = $this->app->make(Storage::class);
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
