<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContentBlock as ContentBlockModel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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

        if ($this->editing_content_block_id) {

            $content_block = ContentBlockModel::findOrFail($this->editing_content_block_id);

            $this->authorize('update', $content_block);

            // Prepare update data
            $updateData = [
                'title' => $this->title,
                'description' => $this->description,
                'content_block_section' => $this->content_block_section,
                'content_block_status' => $this->content_block_status,
                'navigation_link_id' => $this->navigation_link_id,
            ];

            // Only update photo if a new file was uploaded
            if ($this->photo instanceof TemporaryUploadedFile) {
                // Delete old photo if exists
                if ($content_block->photo) {
                    \Storage::disk('public')->delete($content_block->photo);
                }
                $updateData['photo'] = $this->photo->store('content_block_photos', 'public');
            }

            $content_block->update($updateData);

            session()->flash('message', 'Content block updated successfully');

        } else {

            $this->authorize('create', ContentBlockModel::class);

            $createData = [
                'title' => $this->title,
                'description' => $this->description,
                'content_block_section' => $this->content_block_section,
                'content_block_status' => $this->content_block_status,
                'navigation_link_id' => $this->navigation_link_id,
                'user_id' => Auth::id(),
            ];

            // Only add photo if uploaded
            if ($this->photo instanceof TemporaryUploadedFile) {
                $createData['photo'] = $this->photo->store('content_block_photos', 'public');
            }

            ContentBlockModel::create($createData);

            session()->flash('message', 'Content block added successfully');
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

        // Reset validation errors
        $this->resetValidation();
    }

    public function cancel_edit()
    {
        $this->resetForm();
        session()->flash('message', 'Edit cancelled');
    }

    public function edit($id)
    {
        $content_block = ContentBlockModel::findOrFail($id);

        $this->authorize('view', $content_block);

        $this->editing_content_block_id = $content_block->id;
        $this->title = $content_block->title;
        $this->description = $content_block->description?->toTrixHtml() ?? '';
        $this->content_block_section = $content_block->content_block_section;
        $this->content_block_status = $content_block->content_block_status;
        $this->navigation_link_id = $content_block->navigation_link_id;
        $this->current_photo = $content_block->photo;
        $this->photo = null;
    }

    public function delete($id)
    {
        $content_block = ContentBlockModel::findOrFail($id);

        $this->authorize('delete', $content_block);

        // Delete associated photo
        if ($content_block->photo) {
            \Storage::disk('public')->delete($content_block->photo);
        }

        DB::table('rich_texts')->where('record_type', ContentBlockModel::class)
            ->where('record_id', $content_block->id)
            ->delete();

        $content_block->delete();

        session()->flash('message', 'Content block deleted successfully');
    }

    /**
     * Update photo preview when file is selected
     */
    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'nullable|image|max:1500|mimes:jpg,jpeg,png',
        ]);
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
