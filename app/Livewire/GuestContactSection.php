<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact as ContactModel;
use Illuminate\Support\Facades\Log;


class GuestContactSection extends Component
{

    use WithPagination;

    public function render()
    {
        $contact_content = ContactModel::paginate(10);

        return view('livewire.guest.guest-contact-section', [
            'page_title' => 'Get in touch with me.',
            'contact_content' => $contact_content,
        ]);

    }
}
