<div class="h-full w-full flex flex-col gap-4 rounded-xl">

    @if( session('message') )
        <flux:badge size="lg" color="{{ session('message') ? 'green' : 'red' }}">

            <div class="flex gap-4">
                <div class="py-2 mt-2"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                    <p class="font-bold py-2"> {{ session('message') ? 'Success' : 'Error' }}</p>
                    <p class="text-sm">{{ session('message') ?? session('error') }}</p>
                </div>
            </div>

        </flux:badge>
    @endif

    <h2 class="text-2xl font-semibold mb-4">{{ __($page_title) }}</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        <div class="md:col-span-2 rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 overflow-x-auto">

            <table class="border-collapse border border-gray-400 w-full">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="border border-gray-300 px-2 py-1">#</th>
                        <th class="border border-gray-300 px-2 py-1">Type</th>
                        <th class="border border-gray-300 px-2 py-1">Link</th>
                        <th class="border border-gray-300 px-2 py-1">Icon</th>
                        <th class="border border-gray-300 px-2 py-1">Status</th>
                        <th class="border border-gray-300 px-2 py-1" colspan="2">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($contacts as $contact)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800">
                            <td class="border border-gray-300 px-2 py-1">{{ $contact->id }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $contact->type }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $contact->link }}</td>
                            <td class="border border-gray-300 px-2 py-1">
                                <i class="{{ $contact->icon }} fa-3x" aria-hidden="true"></i>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <flux:badge size="sm" color="{{ $contact->status === 'active' ? 'green' : 'red' }}">{{ $contact->status === 'active' ? 'Active' : 'Inactive' }}</flux:badge>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <flux:button
                                    wire:click="edit({{ $contact->id }})"
                                    class="text-blue-600 hover:underline"
                                    icon="pencil"
                                >
                                    Edit
                                </flux:button>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <flux:button variant="danger" color="red"
                                    wire:click="delete({{ $contact->id }})"
                                    class="text-blue-600 hover:underline"
                                    icon="trash"
                                    wire:confirm="Are you sure you want to delete this link?"
                                >
                                    Delete
                                </flux:button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="my-2">
                {{ $contacts->links() }}
            </div>

        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <h3 class="text-xl font-semibold mb-4">{{ __('Add / Edit contacts') }}</h3>

            <form wire:submit.prevent="save" action="">

                <div class="mb-2">
                    <label class="block mb-1 font-medium" for="type">Type</label>
                    <select wire:model="type" id="type" class="w-full p-2 border border-gray-300 rounded">
                        @foreach ( \App\Models\Contact::TYPES as $type )
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                    @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <flux:input
                        type="text"
                        label="Link"
                        placeholder="Enter contact link here."
                        wire:model="link"
                        id="link"
                    />
                </div>


                <div class="mb-4">
                    <flux:input type="text" label="Font Awesome Icon" placeholder="fa fa-code" wire:model="icon"/>
                    <i class="font-sm text-red-600">Add a font awesome icon code from the official font awesome website</i>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium" for="status">Status</label>
                    <select wire:model="status" id="status" class="w-full p-2 border border-gray-300 rounded">
                         @foreach ( \App\Models\Contact::STATUSES as $status )
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    @if ($editing_contact_id)
                        <flux:button type="button" color="red" wire:click="cancel_edit" variant="danger">
                            Cancel
                        </flux:button>
                    @endif

                    <flux:button variant="primary" color="green" type="submit">
                        {{ $editing_contact_id ? __('Update') : __('Create') }}
                    </flux:button>
                </div>

            </form>

        </div>

    </div>

</div>
@once
    @push('fontawesome')
        <script src="https://kit.fontawesome.com/ca8a2a996a.js" crossorigin="anonymous"></script>
    @endpush
@endonce
