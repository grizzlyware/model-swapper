<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Person extends Model
{
    protected $fillable = [
        'country_id',
    ];

    public function country(): HasOne
    {
        return $this->hasOne(Country::class);
    }

    public function profilePhoto(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
