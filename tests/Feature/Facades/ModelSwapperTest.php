<?php

namespace Grizzlyware\ModelSwapper\Tests\Feature\Facades;

use Grizzlyware\ModelSwapper\Facades\ModelSwapper;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country as OriginalCountry;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\Country as ReplacementCountry;
use Grizzlyware\ModelSwapper\Tests\TestCase;

class ModelSwapperTest extends TestCase
{
    public function testCanSwapModelWithoutException(): void
    {
        ModelSwapper::swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->assertTrue(true);
    }
}
