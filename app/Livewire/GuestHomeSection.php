<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContentBlock as ContentBlockModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class GuestHomeSection extends Component
{
    public function render()
    {
        $welcome_content = ContentBlockModel::where('content_block_section', 'home')->first();

        return view('livewire.guest.guest-home-section', [
            'page_title' => $welcome_content->title ?? 'Welcome to My Portfolio',
            'home_content' => $welcome_content,
        ]);
    }
}
