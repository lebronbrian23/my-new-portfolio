<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Skill as SkillModel;

class Skill extends Component
{

    #[Validate('required|string')]
    public $name;

    public $new_name;

    #[Validate('nullable|string')]
    public $description;

    public $new_description;

    #[Validate('nullable|string')]
    public $icon;

    public $new_icon;

    public function add()
    {
        $this->authorize('create', SkillModel::class);

        $this->validate();

        $skill = new SkillModel();
        $skill->name = $this->name;
        $skill->description = $this->description;
        $skill->icon = $this->icon;
        $skill->user_id = Auth::user()->id;
        $skill->save();

        $this->reset();

        session()->flash('message', 'Skill Added');

    }

    public function update($id)
    {
        $this->validate([
            'new_name' => 'required|string',
            'new_description' => 'required|string',
            'new_icon' => 'nullable|string',
        ]);

        $skill = SkillModel::where('id', $id)->first();

        $this->authorize('update', $skill);

        $skill->update([
            'name' => $this->new_name,
            'description' => $this->new_description,
            'icon' => $this->new_icon,
        ]);

        $this->reset();

        session()->flash('message', 'Skill Updated');

    }

    public function delete($id)
    {

        $skill = SkillModel::findorfail($id);

        $this->authorize('delete', $skill);

        $skill->delete();

        session()->flash('message', 'Skill Deleted');
    }

    public function render()
    {
        $skills = SkillModel::all();

        return view('livewire.skill',['skills' => $skills , 'title' => 'Skills']);
    }
}
