<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    public function country(): HasOne
    {
        return $this->hasOne(Country::class);
    }
}
