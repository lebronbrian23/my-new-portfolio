<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Work;

class Skill extends Model
{
    use HasFactory;
    //

    protected $fillable = [
        'name',
        'description',
        'icon',
        'user_id'
    ];


    public function works(): BelongsToMany
    {
        return $this->belongsToMany(Work::class, 'skill_works');
    }

}
