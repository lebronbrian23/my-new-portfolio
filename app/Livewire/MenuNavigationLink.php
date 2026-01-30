<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NavigationLink as NavigationLinkModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;

class MenuNavigationLink extends Component
{

    public function render()
    {
        $links = NavigationLinkModel::select(
            'link_name',
            'link_route',
            'link_icon',
            'link_position',
            'link_location',
            'link_status',
            'user_id',
            )
        ->latest()
        ->orderby('link_position')
        ->paginate(10);

        return view('livewire.menu-navigation-link', ['page_title' => 'Menu Navigation Links' , 'links' => $links ]);
    }
}
