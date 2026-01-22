<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NavigationLink as NavigationLinkModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;

class NavigationLink extends Component
{

    #[Validate('required|string')]
    public $link_name;

    public $new_link_name;

    #[Validate('required|string')]
    public $link_route;

    public $new_link_route;

    #[Validate('integer')]
    public $link_position;

    public $new_link_position;


    #[Validate('string|nullable')]
    public $link_icon;

    public $new_link_icon;

    public function add() {

        $this->validate();

        $this->authorize('create', NavigationLinkModel::class);

        NavigationLinkModel::create([
            'link_name' => $this->link_name,
            'link_route' => $this->link_route,
            'link_position' => $this->link_position,
            'link_icon' => $this->link_icon,
            'user_id' => Auth::user()->id
        ]);

        $this->reset();

        session()->flash('message' , 'Link Added');

    }

    public function update($id)
    {

        $this->validate([
            'new_link_name' => 'required|string',
            'new_link_route' => 'required|string',
            'new_link_position' => 'nullable|integer',
            'new_link_icon' => 'nullable|string',
        ]);

        $link = NavigationLinkModel::where('id', $id)->first();

        $this->authorize('update', $link);

        $link->update([
            'link_name' => $this->new_link_name,
            'link_route' => $this->new_link_route,
            'link_position' => $this->new_link_position,
            'link_icon' => $this->new_link_icon,
        ]);

        $this->reset();

        session()->flash('message' , 'Link Added');
    }

    public function delete($id)
    {
        $link = NavigationLinkModel::findorfail($id);

        $this->authorize('delete', $link);

        $link->delete();

        session()->flash('message','Link deleted');
    }


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
        ->with([
            'content_block',
        ])
        ->latest()
        ->paginate(10);

        return view('livewire.navigation-link', ['title' => 'Navigation Links' , 'links' => $links ]);
    }
}
