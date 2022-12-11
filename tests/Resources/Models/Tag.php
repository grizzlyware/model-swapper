<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    public function countries(): MorphToMany
    {
        return $this->morphedByMany(Country::class, 'taggable');
    }
}
