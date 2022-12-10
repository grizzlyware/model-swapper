<?php

namespace Grizzlyware\ModelSwapper;

use Grizzlyware\ModelSwapper\Services\ModelSwapperService;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ModelSwapperService::class
        );
    }
}
