<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContentBlock as ContentBlockModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class GuestAboutSection extends Component
{

    public function render()
    {
        $about_content = ContentBlockModel::where('content_block_section', 'about')->first();

        return view('livewire.guest.guest-about-section', [
            'page_title' => 'About me',
            'about_content' => $about_content,
        ]);
    }
}
