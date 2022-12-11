<?php

namespace Grizzlyware\ModelSwapper;

use Grizzlyware\ModelSwapper\Contracts\ModelSwapperServiceInterface;
use Grizzlyware\ModelSwapper\Services\ModelSwapperService;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ModelSwapperServiceInterface::class,
            ModelSwapperService::class
        );
    }
}
