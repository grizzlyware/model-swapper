<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Country extends Model
{
    protected $fillable = [
        'continent_id',
    ];

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function leader(): HasOne
    {
        return $this->hasOne(Person::class);
    }
}
