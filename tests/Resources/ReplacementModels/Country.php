<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels;

use Grizzlyware\ModelSwapper\Tests\Resources\Models\Country as OriginalCountry;
use Grizzlyware\ModelSwapper\Traits\IsReplacementModel;

class Country extends OriginalCountry
{
    use IsReplacementModel;
}
