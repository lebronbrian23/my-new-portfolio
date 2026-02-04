<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Skill as SkillModel;
use Livewire\WithPagination;

class Skill extends Component
{

    use WithPagination;

    public ?int $editing_skill_id = null;
    public $name;
    public $description;
    public $icon;

    protected function rules() {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ];
    }

    protected function data(){
        return [
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
        ];
    }

    protected function resetForm(): void
    {
        $this->reset([
            'editing_skill_id',
            'name',
            'description',
            'icon',
        ]);
    }

    public function cancel_edit()
    {
        $this->resetForm();
    }

    public function save()
    {

        if (! Auth::check()) {
            abort(403);
        }

        $this->validate();

        if ( $this->editing_skill_id ) {

            $skill = SkillModel::where('id', $this->editing_skill_id)->first();

            $this->authorize('update', $skill);

            $skill->update([
                'name' => $this->name,
                'description' => $this->description,
                'icon' => $this->icon,
            ]);

            session()->flash('message', 'Skill Updated');

        } else {

            $this->authorize('create', SkillModel::class);


            $skill = new SkillModel();
            $skill->name = $this->name;
            $skill->description = $this->description;
            $skill->icon = $this->icon;
            $skill->user_id = Auth::user()->id;
            $skill->save();

            session()->flash('message', 'Skill Added');
        }

         $this->resetForm();

    }

    public function edit($id)
    {
        $skill = SkillModel::where('id', $id)->first();

        $this->authorize('view', $skill);

        $this->editing_skill_id = $skill->id;
        $this->name = $skill->name;
        $this->description = $skill->description;
        $this->icon = $skill->icon;
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
        $skills = SkillModel::paginate(10);

        return view('livewire.admin.skill',['skills' => $skills , 'page_title' => 'Manage Skills']);
    }
}
