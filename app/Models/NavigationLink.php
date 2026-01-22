<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NavigationLink extends Model
{
    //
    protected $fillable = [
        'link_name',
        'link_route',
        'link_icon',
        'link_position',
        'link_location',
        'link_status',
        'user_id'
    ];


    /**
     * Each NavigationLink may have one related ContentBlock
     */
    public function content_block(): HasOne
    {
         return $this->hasOne(ContentBlock::class, 'navigation_link_id', 'id')
            ->withDefault([
                'title' => null,
                'description' => null,
                'photo' => null,
                'content_block_section' => null,
                'content_block_status' => null
            ]);
    }
}
