<?php

namespace Grizzlyware\ModelSwapper\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ModelSwapperService
{
    /**
     * @param class-string<Model> $original
     * @param class-string<Model> $replacement
     */
    public function swap(string $original, string $replacement): void
    {
        $original::addGlobalScope('swapModel', function (Builder $builder) use ($replacement): void {
            $builder->setModel(
                $replacement::query()->getModel()
            );
        });
    }
}
