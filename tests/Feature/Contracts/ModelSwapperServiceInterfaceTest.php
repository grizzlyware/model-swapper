<?php

namespace Grizzlyware\ModelSwapper\Tests\Feature\Contracts;

use Grizzlyware\ModelSwapper\Contracts\ModelSwapperServiceInterface;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Continent as OriginalContinent;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country as OriginalCountry;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Image;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Image as OriginalImage;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\NonEloquentModel;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Person as OriginalPerson;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Tag as OriginalTag;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\Continent as ReplacementContinent;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\Country as ReplacementCountry;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\Image as ReplacementImage;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\Person as ReplacementPerson;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\PersonWithoutRequiredTrait;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\RenamedCountryModel;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\ReplacementNonEloquentModel;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\Tag as ReplacementTag;
use Grizzlyware\ModelSwapper\Tests\TestCase;

/**
 * @todo Test eager loading
 * @todo Test relation query loading
 */
class ModelSwapperServiceInterfaceTest extends TestCase
{
    private ModelSwapperServiceInterface $modelSwapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->modelSwapper = resolve(ModelSwapperServiceInterface::class);

        $this->setupModelData();
    }

    private function setupModelData(): void
    {
        /**
         * Create the models
         */
        /** @var OriginalContinent $continent */
        $continent = OriginalContinent::query()->create();

        /** @var OriginalCountry $country */
        $country = OriginalCountry::query()->create([
            'continent_id' => $continent->id,
        ]);

        /** @var OriginalPerson $person */
        $person = OriginalPerson::query()->create([
            'country_id' => $country->id,
        ]);

        $image1 = new OriginalImage();
        $image2 = new OriginalImage();

        /** @var OriginalTag $tag1 */
        $tag1 = OriginalTag::query()->create();

        /**
         * Associate polymorphic relationships
         */
        $continent->photos()->save($image1);
        $person->profilePhoto()->save($image2);
        $country->tags()->attach($tag1->id);
    }

    public function testHasOneRelationLoadsCorrectly(): void
    {
        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->modelSwapper->swap(
            OriginalPerson::class,
            ReplacementPerson::class
        );

        $this->assertInstanceOf(
            ReplacementPerson::class,
            OriginalCountry::query()->firstOrFail()->leader
        );
    }

    public function testBelongsToRelationLoadsCorrectly(): void
    {
        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->modelSwapper->swap(
            OriginalPerson::class,
            ReplacementPerson::class
        );

        $this->assertInstanceOf(
            ReplacementCountry::class,
            OriginalPerson::query()->firstOrFail()->country
        );
    }

    public function testHasManyRelationLoadsCorrectly(): void
    {
        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->modelSwapper->swap(
            OriginalPerson::class,
            ReplacementPerson::class
        );

        $this->assertInstanceOf(
            ReplacementPerson::class,
            OriginalCountry::query()->firstOrFail()->people->firstOrFail()
        );
    }

    public function testHasOneThroughRelationLoadsCorrectly(): void
    {
        $this->modelSwapper->swap(
            OriginalContinent::class,
            ReplacementContinent::class
        );

        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->modelSwapper->swap(
            OriginalPerson::class,
            ReplacementPerson::class
        );

        $this->assertInstanceOf(
            ReplacementPerson::class,
            OriginalContinent::query()->firstOrFail()->leader
        );
    }

    public function testHasManyThroughRelationLoadsCorrectly(): void
    {
        $this->modelSwapper->swap(
            OriginalContinent::class,
            ReplacementContinent::class
        );

        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->modelSwapper->swap(
            OriginalPerson::class,
            ReplacementPerson::class
        );

        $this->assertInstanceOf(
            ReplacementPerson::class,
            OriginalContinent::query()->firstOrFail()->people->firstOrFail()
        );
    }

    public function testMorphToRelationLoadsCorrectly(): void
    {
        $this->modelSwapper->swap(
            OriginalImage::class,
            ReplacementImage::class
        );

        $this->modelSwapper->swap(
            OriginalContinent::class,
            ReplacementContinent::class
        );

        /** @var OriginalImage $image */
        $image = Image::query()->where(
            'imageable_type',
            OriginalContinent::class
        )->firstOrFail();

        $this->assertInstanceOf(
            ReplacementContinent::class,
            $image->imageable
        );
    }

    public function testMorphOneRelationLoadsCorrectly(): void
    {
        $this->modelSwapper->swap(
            OriginalImage::class,
            ReplacementImage::class
        );

        $this->modelSwapper->swap(
            OriginalPerson::class,
            ReplacementPerson::class
        );

        /** @var OriginalPerson $person */
        $person = OriginalPerson::query()->firstOrFail();

        $this->assertInstanceOf(
            ReplacementImage::class,
            $person->profilePhoto
        );
    }

    public function testMorphToManyRelationLoadsCorrectly(): void
    {
        $this->modelSwapper->swap(
            OriginalTag::class,
            ReplacementTag::class
        );

        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        $this->assertInstanceOf(
            ReplacementTag::class,
            OriginalCountry::query()->firstOrFail()->tags->firstOrFail()
        );
    }

    public function testMorphedByManyRelationLoadsCorrectly(): void
    {
        $this->modelSwapper->swap(
            OriginalTag::class,
            ReplacementTag::class
        );

        $this->modelSwapper->swap(
            OriginalCountry::class,
            ReplacementCountry::class
        );

        /** @var OriginalTag $tag */
        $tag = OriginalTag::query()->get()->firstOrFail(function(OriginalTag $tag): bool {
            return count($tag->countries) > 0;
        });

        $this->assertInstanceOf(
            ReplacementCountry::class,
            $tag->countries->firstOrFail()
        );
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
            OriginalCountry::class
        ));

        $this->modelSwapper->swap(
            OriginalCountry::class,
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
            OriginalPerson::class,
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
