<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContentBlock as ContentBlockModel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ContentBlock extends Component
{
    use WithFileUploads;

    public $title;
    public $new_title;

    public $description;
    public $new_description;

    public $photo;
    public $new_photo;

    public ?string $content_block_section = null;
    public ?string $new_content_block_section = null;

    public string $content_block_status = 'active';
    public string $new_content_block_status;

    public ?int $navigation_link_id = null;
    public ?int $new_navigation_link_id = null;

    /**
     * Validation rules
     */
    protected function rules($context = 'add'): array
    {
        $baseRules = [
            'title' => 'required|string',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:1500|mimes:jpg,jpeg,png',
            'content_block_section' => ['nullable', Rule::in(ContentBlockModel::SECTIONS)],
            'content_block_status' => ['required', Rule::in(ContentBlockModel::STATUSES)],
            'navigation_link_id' => 'nullable|integer',
        ];

        if ($context === 'update') {

            return [
                'new_title' => $baseRules['title'],
                'new_description' => $baseRules['description'],
                'new_photo' => $baseRules['photo'],
                'new_content_block_section' => $baseRules['content_block_section'],
                'new_content_block_status' => $baseRules['content_block_status'],
                'new_navigation_link_id' => $baseRules['navigation_link_id'],
            ];
        }

        return $baseRules;
    }

    public function add()
    {
        if (! Auth::check()) {
            abort(403);
        }
        
        $this->authorize('create', ContentBlockModel::class);

        $this->validate($this->rules('add'));

        ContentBlockModel::create([
            'title' => $this->title,
            'description' => $this->description,
            'photo' => $this->photo ? $this->photo->store('content_block_photos', 'public') : null,
            'user_id' => Auth::user()->id,
            'content_block_section' => $this->content_block_section,
            'content_block_status' => $this->content_block_status,
            'navigation_link_id' => $this->navigation_link_id,
        ]);

        $this->reset();

        session()->flash('message', 'Content block added');
    }

    public function update($id)
    {
        $content_block = ContentBlockModel::findOrFail($id);

        $this->authorize('update', $content_block);

        $this->validate($this->rules('update'));

        $content_block->update([
            'title' => $this->new_title,
            'description' => $this->new_description,
            'photo' => $this->new_photo ? $this->new_photo->store('content_block_photos', 'public') : $content_block->photo,
            'content_block_section' => $this->new_content_block_section,
            'content_block_status' => $this->new_content_block_status,
            'navigation_link_id' => $this->new_navigation_link_id,
        ]);

        $this->reset();

        session()->flash('message', 'Content block updated');
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

        return view('livewire.content-block', [
            'page_title' => 'Content Blocks',
            'content_blocks' => $content_blocks,
        ]);
    }
}
