<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Work as WorkModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Image;
use Livewire\WithFileUploads;

class Work extends Component
{
    use WithFileUploads;

    #[Validate('required|string')]
    public $title;


    public $new_title;

    #[Validate('required|string')]
    public $description;


    public $new_description;

    #[Validate('nullable|array')]
    public $skills;


    public $new_skills;

    #[Validate('nullable|image|max:1500|mimes:jpg,jpeg,png')]
    public $photo;

    public $new_photo;


    public function add()
    {

        $this->authorize('create', WorkModel::class);

        $this->validate();

        $work = WorkModel::create([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => Auth::user()->id
        ]);

        $work->skills()->attach($this->skills);

        if( ! empty($this->photo) ){
            Image::create([
                'url' => $this->photo->store('works_photos', 'public'),
                'imageable_id' => $work->id,
                'imageable_type' =>  WorkModel::class
            ]);
        }

        $this->reset();

        session()->flash('message', 'Skill added');

    }

    public function update($id)
    {
        $this->validate([
            'new_title' => 'required|string',
            'new_description' => 'required|string',
            'new_skills' => 'nullable|array',
            'new_photo' => 'nullable|image|max:1500|mimes:jpg,jpeg,png'
        ]);


        $work = WorkModel::where('id', $id)->first();

        $this->authorize('update', $work);

        $work->update([
            'title' => $this->new_title,
            'description' => $this->new_description,
            'user_id' => Auth::user()->id
        ]);

        if ( !empty($this->new_skills) ) {
            $work->skills()->sync($this->new_skills);
        }

        if( !empty($this->new_photo) ){
            $image = Image::where('id', $work->image->id)->first();

            $image->update([
                'url' => $this->new_photo->store('works_photos', 'public'),
            ]);
        }

        $this->reset();

        session()->flash('message', 'Skill updated');

    }

    public function delete($id)
    {
        $work = WorkModel::findorfail($id);

        $this->authorize('delete', $work);

        $work->skills()->detach();

        $work->delete();

        session()->flash('message','Work deleted');
    }

    public function render()
    {
        $works = WorkModel::select(
            'title',
            'description',
            'user_id'
            )
        ->with([
            'skills:id,name,icon',
            'image:id,url,imageable_id,imageable_type',
        ])
        ->latest()
        ->paginate(10);

        return view('livewire.work', [
            'title' => 'Works',
            'works' => $works
        ]);
    }
}
