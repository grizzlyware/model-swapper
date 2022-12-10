<?php

namespace Grizzlyware\ModelSwapper\Tests\Feature\Services;

use Grizzlyware\ModelSwapper\Services\ModelSwapperService;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country;
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

        OriginalCountry::create();
    }

    public function testCanSwapModelWithoutException(): void
    {
        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->assertTrue(true);
    }

    public function testExceptionIsThrownIfReplacementDoesNotExtendOriginal(): void
    {
        $this->markTestSkipped();
    }

    public function testReplacementClassIsReturnedFromQueryBuilder(): void
    {
        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->assertInstanceOf(
            ReplacementCountry::class,
            OriginalCountry::query()->firstOrFail()
        );
    }

    public function testReplacementClassIsNotReturnedIfNotSwapped(): void
    {

        $this->assertInstanceOf(
            OriginalCountry::class,
            OriginalCountry::query()->firstOrFail()
        );
    }
}
