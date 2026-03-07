<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Skill as SkillModel;
use Illuminate\Support\Facades\Log;


class GuestSkillSection extends Component
{

    use WithPagination;

    public function render()
    {
        $skill_content = SkillModel::all();

        return view('livewire.guest.guest-skill-section', [
            'page_title' => 'Skills & Tools',
            'skill_content' => $skill_content,
        ]);

    }
}
