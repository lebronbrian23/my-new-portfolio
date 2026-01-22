<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact as ContactModel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class Contact extends Component
{

    public $link;
    public $new_link;

    public $icon;
    public $new_icon;

    public $status;
    public $new_status;

    public $type;
    public $new_type;

    protected function rules($context = 'add'): array
    {
        $base_rules = [
            'icon' => 'string',
            'type' => ['required', Rule::in(ContactModel::TYPES)],
            'link' => 'string|required',
            'status' => ['nullable', Rule::in(ContactModel::STATUSES)]

        ];

        if ($context === 'update') {
            return [
                'new_icon' => $base_rules['icon'],
                'new_type' => $base_rules['type'],
                'new_link' => $base_rules['link'],
                'new_status' => $base_rules['status']
            ];
        }


        return $base_rules;

    }

    public function add()
    {

        $this->authorize('create', ContactModel::class);

        $this->validate($this->rules('add'));

        ContactModel::create([
            'icon' => $this->icon,
            'type' => $this->type,
            'link' => $this->link,
            'user_id' => Auth::user()->id
        ]);

        $this->reset();

        session()->flash('message', 'Contact added');
    }


    public function update($id)
    {
        $contact = ContactModel::where('id', $id)->first();

        $this->authorize('update', $contact);

        $this->validate($this->rules('update'));

        $contact->update([
            'icon' => $this->new_icon,
            'type' => $this->new_type,
            'link' => $this->new_link,
            'status' => $this->new_status
        ]);

        $this->reset();

        session()->flash('message', 'Contact updated');

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
        $contacts = ContactModel::all();

        return view('livewire.contact',['title' => 'Contact' , 'contacts' => $contacts]);
    }
}
