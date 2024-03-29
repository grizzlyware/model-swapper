<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\Observers;

use Grizzlyware\ModelSwapper\Tests\Resources\Exceptions\CountryUpdatedException;
use Grizzlyware\ModelSwapper\Tests\Resources\Jobs\CountCountryPopulation;
use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country;

class CountryObserver
{
    public function created(Country $country): void
    {
        dispatch(new CountCountryPopulation($country));
    }

    public function updated(Country $country): void
    {
        throw new CountryUpdatedException($country);
    }
}
