<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public const TYPES = [
        'email','phone','linkedIn','github','x'
    ];

    public const STATUSES = ['active', 'inactive'];
    //
    protected $fillable = ['icon', 'status', 'type', 'link', 'user_id'];
}
