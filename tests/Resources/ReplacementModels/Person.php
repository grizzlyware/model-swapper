<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\ReplacementModels;

use Grizzlyware\ModelSwapper\Traits\IsReplacementModel;

class Person extends \Grizzlyware\ModelSwapper\Tests\Resources\Models\Person
{
    use IsReplacementModel;
}
