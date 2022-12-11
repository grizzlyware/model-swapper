<?php

namespace Grizzlyware\ModelSwapper\Tests\Feature\Traits;

use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country;
use Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels\Country as ReplacementCountry;
use Grizzlyware\ModelSwapper\Tests\TestCase;
use Grizzlyware\ModelSwapper\Traits\IsReplacementModel;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @see IsReplacementModel
 */
class IsReplacementModelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Reset the morph map
        Relation::morphMap([], false);
    }

    public function testCanGetOwnMorphKeyWhenSet(): void
    {
        Relation::morphMap([
            'replacement_country_key' => ReplacementCountry::class,
        ]);

        $model = new ReplacementCountry();

        $this->assertEquals(
            'replacement_country_key',
            $model->getMorphClass()
        );
    }

    public function testUsesReplacedModelsMorphKeyWhenOwnNotSet(): void
    {
        $model = new ReplacementCountry();

        $this->assertEquals(
            Country::class,
            $model->getMorphClass()
        );
    }

    public function testUsesReplacedModelsMorphKeyWithMapWhenOwnNotSet(): void
    {
        Relation::morphMap([
            'original_country' => Country::class,
        ]);

        $model = new ReplacementCountry();

        $this->assertEquals(
            'original_country',
            $model->getMorphClass()
        );
    }
}
