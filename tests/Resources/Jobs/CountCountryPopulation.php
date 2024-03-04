<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\Jobs;

use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country;

class CountCountryPopulation
{
    public function __construct(public readonly Country $country)
    {
        //
    }
}
