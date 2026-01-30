<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NavigationLink as NavigationLinkModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;

class NavigationLink extends Component
{

    public ?int $editing_link_id = null;

    public $link_name;
    public $link_route;
    public $link_icon;
    public $link_position;
    public $link_location = 'header';
    public $link_status = 'active';

    protected function rules()
    {
        return [
            'link_name' => 'required|string',
            'link_route' => 'required|string',
            'link_position' => 'nullable|integer',
            'link_icon' => 'nullable|string',
            'link_status' => 'nullable|string',
            'link_location' => 'nullable|string',
        ];
    }

    private function data(): array
    {
        return [
            'link_name' => $this->link_name,
            'link_route' => $this->link_route,
            'link_icon' => $this->link_icon,
            'link_position' => $this->link_position,
            'link_location' => $this->link_location,
            'link_status' => $this->link_status,
        ];
    }

    public function cancel_edit()
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'editing_link_id',
            'link_name',
            'link_route',
            'link_icon',
            'link_position',
            'link_location',
            'link_status',
        ]);
    }


    public function save() {


        if (! Auth::check()) {
            abort(403);
        }
        
        $this->validate();

        if ( $this->editing_link_id)
        {
            $link = NavigationLinkModel::where('id', $this->editing_link_id)->first();

            $this->authorize('update', $link);

            $link->update($this->data());

            session()->flash('message' , 'Link updated');
        } else {

            $this->authorize('create', NavigationLinkModel::class);

            NavigationLinkModel::create(
                array_merge($this->data(), [
                    'user_id' => Auth::id(),
                ])
            );

            session()->flash('message' , 'Link created');
        }

        $this->resetForm();

    }

    public function edit($id)
    {
        $link = NavigationLinkModel::where('id', $id)->first();

        $this->authorize('view', $link);

        $this->editing_link_id = $id;

        $this->fill([
            'link_name' => $link->link_name,
            'link_route' => $link->link_route,
            'link_icon' => $link->link_icon,
            'link_position' => $link->link_position,
            'link_location' => $link->link_location,
            'link_status' => $link->link_status,
        ]);

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
            'id',
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

        return view('livewire.navigation-link', ['page_title' => 'Manage Navigation Links' , 'links' => $links ]);
    }
}
