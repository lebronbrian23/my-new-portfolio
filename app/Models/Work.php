<?php

namespace App\Models;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Image;

class Work extends Model
{

    protected $fillable = [
        'description',
        'title',
        'user_id',
        'url',
        'is_api'
    ];

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'skill_works');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
