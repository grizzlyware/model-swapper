<?php

namespace Grizzlyware\ModelSwapper\Contracts;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

interface ModelSwapperServiceInterface
{
    /**
     * @param class-string<Model> $original
     * @param class-string<Model> $replacement
     * @throws InvalidArgumentException
     */
    public function swap(string $original, string $replacement): void;
}
