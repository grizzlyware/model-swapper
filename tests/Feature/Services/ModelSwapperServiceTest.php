<?php

namespace Grizzlyware\ModelSwapper\Tests\Feature\Services;

use Grizzlyware\ModelSwapper\Services\ModelSwapperService;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country as OriginalCountry;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\Country as ReplacementCountry;
use Grizzlyware\ModelSwapper\Tests\TestCase;

class ModelSwapperServiceTest extends TestCase
{
    private ModelSwapperService $modelSwapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->modelSwapper = resolve(ModelSwapperService::class);
    }

    public function testCanSwapModelWithoutException(): void
    {
        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->assertTrue(true);
    }
}
