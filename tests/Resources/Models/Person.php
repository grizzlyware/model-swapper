<?php

namespace Grizzlyware\ModelSwapper\Tests\Resources\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Person extends Model
{
    protected $fillable = [
        'country_id',
    ];

    public function profilePhoto(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
