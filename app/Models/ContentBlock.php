<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class ContentBlock extends Model
{
    use HasRichText;

    protected $richTextAttributes = [
        'description',
    ];

    public const SECTIONS = [
        'welcome',
        'about',
        'work',
        'skill',
        'contact',
        'resume'
    ];

    public const STATUSES = [
        'active',
        'inactive',
    ];

    protected $fillable = ['title', 'description','photo', 'user_id','content_block_section','content_block_status','navigation_link_id'];


    /**
     * ContentBlock belongs to a NavigationLink
     */
    public function navigation_link(): BelongsTo
    {
        // Specify the foreign key on ContentBlock and the owner key
        return $this->belongsTo(NavigationLink::class, 'navigation_link_id', 'id');
    }
}
