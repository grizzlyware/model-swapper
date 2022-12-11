<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Continent extends Model
{
    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }

    public function people(): HasManyThrough
    {
        return $this->hasManyThrough(Person::class, Country::class);
    }

    public function leader(): HasOneThrough
    {
        return $this->hasOneThrough(Person::class, Country::class);
    }
}
