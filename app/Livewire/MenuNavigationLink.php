<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NavigationLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

class MenuNavigationLink extends Component
{
    use WithPagination;

    public function render()
    {
        $links = NavigationLink::select(
            'id',
            'link_name',
            'link_route',
            'link_icon',
            'link_position',
            'link_location',
            'link_status',
            'user_id'
        )
        ->latest()
        ->whereNotIn('link_name' ,[ 'Resume', 'Home' ,'About'])
        ->orderBy('link_position')
        ->get()
        ->map(function ($link) {
            $link->admin_link_route = 'admin.' . $link->link_route;
            return $link;
        });

        return view('livewire.admin.menu-navigation-link', [
            'page_title' => 'Menu Navigation Links',
            'links' => $links,
        ]);
    }
}
