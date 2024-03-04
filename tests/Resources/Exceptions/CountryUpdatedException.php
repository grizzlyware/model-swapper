<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\Exceptions;

use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country;

class CountryUpdatedException extends \Exception
{
    public readonly Country $country;

    public function __construct(Country $country)
    {
        $this->country = $country;

        parent::__construct("Country {$country->name} has been updated");
    }
}
