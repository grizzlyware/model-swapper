<?php

namespace Grizzlyware\ModelSwapper\Facades;

use Grizzlyware\ModelSwapper\Services\ModelSwapperService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void swap(string $original, string $replacement)
 */
class ModelSwapper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ModelSwapperService::class;
    }
}
