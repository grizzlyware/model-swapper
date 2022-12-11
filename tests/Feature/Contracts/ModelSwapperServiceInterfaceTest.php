<?php

namespace Grizzlyware\ModelSwapper\Tests\Feature\Contracts;

use Grizzlyware\ModelSwapper\Contracts\ModelSwapperServiceInterface;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country as OriginalCountry;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\NonEloquentModel;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Person;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\Country as ReplacementCountry;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\Person as ReplacementPerson;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\PersonWithoutRequiredTrait;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\RenamedCountryModel;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\ReplacementNonEloquentModel;
use Grizzlyware\ModelSwapper\Tests\TestCase;

class ModelSwapperServiceInterfaceTest extends TestCase
{
    private ModelSwapperServiceInterface $modelSwapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->modelSwapper = resolve(ModelSwapperServiceInterface::class);

        OriginalCountry::query()->create();
    }

    public function testHasOneRelationLoadsCorrectly(): void
    {
        $this->markTestSkipped();
    }

    public function testBelongsToRelationLoadsCorrectly(): void
    {
        $this->markTestSkipped();
    }

    public function testHasManyRelationLoadsCorrectly(): void
    {
        $this->markTestSkipped();
    }

    public function testHasOneThroughRelationLoadsCorrectly(): void
    {
        $this->markTestSkipped();
    }

    public function testHasManyThroughRelationLoadsCorrectly(): void
    {
        $this->markTestSkipped();
    }

    public function testMorphToRelationLoadsCorrectly(): void
    {
        $this->markTestSkipped();
    }

    public function testMorphOneRelationLoadsCorrectly(): void
    {
        $this->markTestSkipped();
    }

    public function testMorphToManyRelationLoadsCorrectly(): void
    {
        $this->markTestSkipped();
    }

    public function testMorphedByManyRelationLoadsCorrectly(): void
    {
        $this->markTestSkipped();
    }

    public function testServiceResolves(): void
    {
        $this->assertInstanceOf(
            ModelSwapperServiceInterface::class,
            resolve(ModelSwapperServiceInterface::class)
        );
    }

    public function testGettingReplacedModelQueryReturnsReplacedModel(): void
    {
        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->assertEquals(
            OriginalCountry::class,
            get_class(ReplacementCountry::replacedModelQuery()->firstOrFail())
        );
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
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(sprintf(
            "Replacement class '%s' does not extend original class '%s'",
            ReplacementPerson::class,
            Country::class
        ));

        $this->modelSwapper->swap(
            Country::class,
            ReplacementPerson::class,
        );
    }

    public function testExceptionIsThrownIfOriginalClassIsNotLaravelModel(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(sprintf(
            "Original class '%s' is not an Eloquent model",
            NonEloquentModel::class
        ));

        $this->modelSwapper->swap(
            NonEloquentModel::class,
            ReplacementNonEloquentModel::class,
        );
    }

    public function testExceptionIsThrownIfReplacementClassDoesNotUseIsReplacementModelTrait(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(sprintf(
            "Replacement class '%s' does not use IsReplacementModel trait",
            PersonWithoutRequiredTrait::class
        ));

        $this->modelSwapper->swap(
            Person::class,
            PersonWithoutRequiredTrait::class,
        );
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

    public function testReplacementClassIsReturnedFromQueryBuilderIfNameIsDifferent(): void
    {
        $this->modelSwapper->swap(
            OriginalCountry::class,
            RenamedCountryModel::class
        );

        $this->assertInstanceOf(
            RenamedCountryModel::class,
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
