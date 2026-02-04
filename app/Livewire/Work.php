<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Work as WorkModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Image;

class Work extends Component
{
    use WithFileUploads, WithPagination;

    public ?int $editing_work_id = null;
    public $title;
    public $description;
    public $skills;
    public $photo;
    public $current_photo;


    protected $rules = [
        'title' => 'required|string',
        'description' => 'required|string',
        'skills' => 'nullable|array',
        'photo' => 'nullable|image|max:1500|mimes:jpg,jpeg,png'
    ];

    public function edit($id)
    {
        $work = WorkModel::where('id', $id)->first();

        $this->authorize('view', $work);

        $this->editing_work_id = $work->id;
        $this->title = $work->title;
        $this->description = $work->description;
        $this->skills = $work->skills->pluck('id')->toArray();
        $this->current_photo = $work->image->url;
    }

    public function cancel_edit()
    {
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset([
            'editing_work_id',
            'title',
            'description',
            'skills',
            'photo',
        ]);
    }

    protected function data(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'skills' => $this->skills,
            'photo' => $this->photo,
        ];
    }


    public function save()
    {
        if (! Auth::check()) {
            abort(403);
        }

        $this->validate();

        if( $this->editing_work_id ) {

            $work = WorkModel::where('id', $this->editing_work_id)->first();

            $this->authorize('update', $work);

            $work->update([
                'title' => $this->title,
                'description' => $this->description,
                'user_id' => Auth::user()->id
            ]);

            if ( !empty($this->skills) ) {
                $work->skills()->sync($this->skills);
            }

            if( !empty($this->photo) ){
                $image = Image::where('id', $work->image->id)->first();

                if ($work->image) {
                    $image->update([
                        'url' => $this->photo->store('works_photos', 'public'),
                    ]);
                } else {
                    Image::create([
                        'url' => $this->photo->store('works_photos', 'public'),
                        'imageable_id' => $work->id,
                        'imageable_type' =>  WorkModel::class
                    ]);
                }
            }

            session()->flash('message', 'Skill updated');

        } else {
            $this->authorize('create', WorkModel::class);


            $work = WorkModel::create([
                'title' => $this->title,
                'description' => $this->description,
                'user_id' => Auth::user()->id
            ]);

            if ( ! empty($this->skills) ) {
                $work->skills()->attach($this->skills);
            }

            if( ! empty($this->photo) ){
                Image::create([
                    'url' => $this->photo->store('works_photos', 'public'),
                    'imageable_id' => $work->id,
                    'imageable_type' =>  WorkModel::class
                ]);
            }

            session()->flash('message', 'Skill added');
        }

        $this->resetForm();

    }


    public function delete($id)
    {
        $work = WorkModel::findorfail($id);

        $this->authorize('delete', $work);

        $work->skills()->detach();

        if ( $work->image ) {
            $work->image->delete();
        }

        $work->delete();

        session()->flash('message','Work deleted');
    }

    public function render()
    {
        $works = WorkModel::select(
            'id',
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

        return view('livewire.admin.work', ['page_title' => 'Manage Works', 'works' => $works]);
    }
}
