<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NavigationLink as NavigationLinkModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;


class GuestNavLinksSection extends Component
{

    public string $location = 'header'; // header, mobile, footer
    public ?string $activeSection = null;

    /**
     * Get navigation links ordered by position
     */
    public function getLinksProperty(): Collection
    {
        return NavigationLinkModel::select(
            'id',
            'link_name',
            'link_route',
            'link_icon',
            'link_position',
            'link_location',
            'link_status',
        )
        ->whereNotIn('link_name',['Content Blocks', 'Navigation Links'])
        ->where('link_status', 'active')
        ->orderBy('link_position','asc')
        ->get();
    }

    /**
     * Check if a link is active based on current URL or section
     */
    public function isActive(NavigationLinkModel $link): bool
    {
        // If activeSection is set by Alpine.js (for hash links)
        if ($this->activeSection) {
            return $link->link_route === $this->activeSection;
        }

        // For regular page routes (not hash links)
        // Examples: 'about', 'contact', 'blog'
        $route = trim($link->link_route, '/');

        // Check exact match
        if (request()->is($route)) {
            return true;
        }

        // Check if current path starts with this route
        if ($route && request()->is($route . '/*')) {
            return true;
        }

        // Check for homepage
        if (($route === '' || $route === 'home') && request()->is('/')) {
            return true;
        }

        return false;
    }

    public function render()
    {
        return view('livewire.guest.guest-nav-links-section', [
            'links' => $this->links,
        ]);
    }

}
