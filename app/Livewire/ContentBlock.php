<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContentBlock as ContentBlockModel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

class ContentBlock extends Component
{
    use WithFileUploads, WithPagination;

    public $title;
    public ?int $editing_content_block_id = null;
    public $description;
    public $photo;
    public $current_photo;
    public ?string $content_block_section = null;
    public string $content_block_status = 'active';
    public ?int $navigation_link_id = null;

    /**
     * Validation rules
     */
    protected function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:1500|mimes:jpg,jpeg,png',
            'content_block_section' => ['nullable', Rule::in(ContentBlockModel::SECTIONS)],
            'content_block_status' => ['required', Rule::in(ContentBlockModel::STATUSES)],
            'navigation_link_id' => 'nullable|integer',
        ];

    }

    public function save()
    {
        if (! Auth::check()) {
            abort(403);
        }

        $this->validate();

        if ( $this->editing_content_block_id ) {

            $content_block = ContentBlockModel::findOrFail($this->editing_content_block_id);

            $this->authorize('update', $content_block);

            $content_block->update([
                'title' => $this->title,
                'description' => $this->description,
                'photo' => $this->photo ? $this->photo->store('content_block_photos', 'public') : $content_block->image->url,
                'content_block_section' => $this->content_block_section,
                'content_block_status' => $this->content_block_status,
                'navigation_link_id' => $this->navigation_link_id,
            ]);

            session()->flash('message', 'Content block updated');

        } else {

            $this->authorize('create', ContentBlockModel::class);

            ContentBlockModel::create([
                'title' => $this->title,
                'description' => $this->description,
                'photo' => $this->photo ? $this->photo->store('content_block_photos', 'public') : null,
                'user_id' => Auth::user()->id,
                'content_block_section' => $this->content_block_section,
                'content_block_status' => $this->content_block_status,
                'navigation_link_id' => $this->navigation_link_id,
            ]);

            session()->flash('message', 'Content block added');

        }

          $this->resetForm();

    }

    protected function resetForm(): void
    {
        $this->reset([
            'editing_content_block_id',
            'title',
            'description',
            'photo',
            'current_photo',
            'content_block_section',
            'content_block_status',
            'navigation_link_id',
        ]);
    }

    protected function data(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'photo' => $this->photo,
            'content_block_section' => $this->content_block_section,
            'content_block_status' => $this->content_block_status,
            'navigation_link_id' => $this->navigation_link_id,
        ];
    }

    public function edit($id)
    {
        $content_block = ContentBlockModel::where('id', $id)->first();

        $this->authorize('view', $content_block);

        $this->editing_content_block_id = $content_block->id;
        $this->title = $content_block->title;
        $this->description = $content_block->description;
        $this->content_block_section = $content_block->content_block_section;
        $this->content_block_status = $content_block->content_block_status;
        $this->navigation_link_id = $content_block->navigation_link_id;
        $this->current_photo = $content_block->image ? $content_block->image->url : null;

    }


    public function delete($id)
    {
        $content_block = ContentBlockModel::findOrFail($id);

        $this->authorize('delete', $content_block);

        $content_block->delete();

        session()->flash('message', 'Content block deleted');
    }

    public function render()
    {
        $content_blocks = ContentBlockModel::with('navigation_link')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.content-block', [
            'page_title' => 'Content Blocks',
            'content_blocks' => $content_blocks,
        ]);
    }
}
