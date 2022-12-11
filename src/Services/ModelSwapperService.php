<?php

namespace Grizzlyware\ModelSwapper\Services;

use Grizzlyware\ModelSwapper\Contracts\ModelSwapperServiceInterface;
use Grizzlyware\ModelSwapper\Traits\IsReplacementModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class ModelSwapperService implements ModelSwapperServiceInterface
{
    /**
     * @param class-string<Model> $original
     * @param class-string<Model> $replacement
     * @throws InvalidArgumentException
     */
    public function swap(string $original, string $replacement): void
    {
        $this->assertOriginalModelIsEloquentModel($original);
        $this->assertReplacementExtendsOriginal($original, $replacement);
        $this->assertReplacementModelUsesRequiredTrait($replacement);

        $original::addGlobalScope('swapModel', function (Builder $builder) use ($replacement): void {
            $builder->setModel(
                $replacement::query()->getModel()
            );
        });
    }

    /**
     * @param class-string $replacement
     * @throws InvalidArgumentException
     */
    private function assertReplacementModelUsesRequiredTrait(string $replacement): void
    {
        if (in_array(IsReplacementModel::class, class_uses($replacement), true)) {
            return;
        }

        throw new InvalidArgumentException(sprintf(
            "Replacement class '%s' does not use IsReplacementModel trait",
            $replacement
        ));
    }

    /**
     * @param class-string $original
     * @throws InvalidArgumentException
     */
    private function assertOriginalModelIsEloquentModel(string $original): void
    {
        if (in_array(Model::class, class_parents($original), true)) {
            return;
        }

        throw new InvalidArgumentException(sprintf(
            "Original class '%s' is not an Eloquent model",
            $original
        ));
    }

    /**
     * @param class-string $original
     * @param class-string $replacement
     * @throws InvalidArgumentException
     */
    private function assertReplacementExtendsOriginal(string $original, string $replacement): void
    {
        if (in_array($original, class_parents($replacement), true)) {
            return;
        }

        throw new InvalidArgumentException(sprintf(
            "Replacement class '%s' does not extend original class '%s'",
            $replacement,
            $original
        ));
    }
}
