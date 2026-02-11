<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Work as WorkModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class GuestWorkSection extends Component
{

    use WithPagination;

    public function render()
    {
        $work_content = WorkModel::select(
            'id',
            'title',
            'description',
            'url'
            )
        ->with([
            'skills:id,name,icon',
            'image:id,url,imageable_id,imageable_type',
        ])
        ->latest()
        ->paginate(10);

        return view('livewire.guest.guest-work-section', [
            'page_title' => 'Some of the things I\'ve built.',
            'work_content' => $work_content,
        ]);

    }
}
