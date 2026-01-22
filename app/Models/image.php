<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class image extends Model
{
    //

    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'url'
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

}
