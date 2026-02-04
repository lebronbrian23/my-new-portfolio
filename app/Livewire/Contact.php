<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact as ContactModel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Contact extends Component
{
    use WithPagination;

    public ?int $editing_contact_id = null;
    public $link;
    public $icon;
    public $status;
    public $type;

    protected function rules(): array
    {
        return [
            'icon' => 'nullable|string',
            'type' => [
                'required',
                Rule::in(ContactModel::TYPES),
                Rule::unique('contacts', 'type')
                    ->ignore($this->editing_contact_id),
            ],
            'link' => 'required|string',
            'status' => [
                'nullable',
                Rule::in(ContactModel::STATUSES),
            ],
        ];
    }


    protected function data(): array
    {
        return [
            'icon' => $this->icon,
            'type' => $this->type,
            'link' => $this->link,
            'status' => $this->status,
        ];
    }

    protected function resetForm(): void
    {
        $this->reset([
            'editing_contact_id',
            'icon',
            'type',
            'link',
            'status',
        ]);
    }

    public function edit($id)
    {
        $contact = ContactModel::where('id', $id)->first();

        $this->authorize('view', $contact);

        $this->editing_contact_id = $contact->id;
        $this->icon = $contact->icon;
        $this->type = $contact->type;
        $this->link = $contact->link;
        $this->status = $contact->status;
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

        if ( $this->editing_contact_id ) {

            $contact = ContactModel::where('id', $this->editing_contact_id)->first();

            $this->authorize('update', $contact);

            $contact->update([
                'icon' => $this->icon,
                'type' => $this->type,
                'link' => $this->link,
                'status' => $this->status
            ]);

            session()->flash('message', 'Contact updated');

        }  else {

            $this->authorize('create', ContactModel::class);

            ContactModel::create([
                'icon' => $this->icon,
                'type' => $this->type,
                'link' => $this->link,
                'user_id' => Auth::user()->id
            ]);

            session()->flash('message', 'Contact added');

        }

        $this->resetForm();
    }

    public function delete($id)
    {
        $contact = ContactModel::findorfail($id);

        $this->authorize('delete', $contact);

        $contact->delete();

        session()->flash('message', 'Contact delete');
    }

    public function render()
    {
        $contacts = ContactModel::paginate(10);

        return view('livewire.admin.contact',['page_title' => 'Contact' , 'contacts' => $contacts]);
    }
}
