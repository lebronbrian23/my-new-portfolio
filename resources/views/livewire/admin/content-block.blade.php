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
                        <th class="border border-gray-300 px-2 py-1">Photo</th>
                        <th class="border border-gray-300 px-2 py-1">Title</th>
                        <th class="border border-gray-300 px-2 py-1">Description</th>
                        <th class="border border-gray-300 px-2 py-1">Content Block Section</th>
                        <th class="border border-gray-300 px-2 py-1">Navigation link id</th>
                        <th class="border border-gray-300 px-2 py-1">Status</th>
                        <th class="border border-gray-300 px-2 py-1" colspan="2">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($content_blocks as $content_block)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800">
                            <td class="border border-gray-300 px-2 py-1">{{ $content_block->id }}</td>
                            <td class="border border-gray-300 px-2 py-1">
                                @if( $content_block->image)
                                    <img src="{{ asset('storage/'.$content_block->image->url) }}" alt="{{ $content_block->title }}" class="h-16 w-16 object-cover rounded">
                                @endif
                            </td>
                            <td class="border border-gray-300 px-2 py-1">{{ $content_block->title }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $content_block->description }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $content_block->content_block_section }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $content_block->navigation_link_id }}</td>
                            <td class="border border-gray-300 px-2 py-1">
                                <flux:badge size="sm" color="{{ $content_block->content_block_status === 'active' ? 'green' : 'red' }}">{{ $content_block->content_block_status === 'active' ? 'Active' : 'Inactive' }}</flux:badge>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <flux:button
                                    wire:click="edit({{ $content_block->id }})"
                                    class="text-blue-600 hover:underline"
                                    icon="pencil"
                                >
                                    Edit
                                </flux:button>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <flux:button variant="danger" color="red"
                                    wire:click="delete({{ $content_block->id }})"
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
                {{ $content_blocks->links() }}
            </div>

        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <h3 class="text-xl font-semibold mb-4">{{ __('Add / Edit content blocks') }}</h3>

            <form wire:submit.prevent="save" action="">

                <div class="mb-2">
                    <flux:textarea type="text" label="Title" placeholder="Enter title here" wire:model="title"/>
                </div>

                <div class="mb-2">
                    <flux:textarea
                        type="text"
                        label="Description"
                        placeholder="Enter description here."
                        wire:model="description"
                        id="description"
                    />
                </div>

                @if( $editing_content_block_id && $current_photo)
                    <div class="mb-2">
                        <label class="block mb-1 font-medium" for="photo">Current Image</label>
                        <div class="mt-2 h-24 w-24">
                            <img src="{{ asset('storage/'.$current_photo) }}" style="width:30%;" alt="Current Photo" class="rounded w-1/2">
                        </div>
                    </div>
                 @endif

                <div class="mb-2">
                    <label class="block mb-1 font-medium" for="photo">Image</label>
                    <input type="file" wire:model="photo" id="photo" accept="image/png, image/jpeg, image/jpg" class=" p-2 border border-gray-300 rounded">
                    @error('photo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">

                    @if($photo && $photo->isPreviewable() )
                        <div class="mt-2 h-24 w-24">
                            <p class="font-medium mb-1">Preview:</p>
                            <img src="{{ $photo->temporaryUrl() }}" style="width:30%;" alt="Photo Preview" class="rounded w-1/2">
                        </div>
                    @endif
                    <div wire:loading wire:target='photo'>
                        <span class="text-green-500">Uploading ....</span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium" for="content_block_section">Section</label>
                    <select wire:model="content_block_section" id="content_block_section" class="w-full p-2 border border-gray-300 rounded">
                         @foreach ( \App\Models\ContentBlock::SECTIONS as $section )
                            <option value="{{ $section }}">{{ ucfirst($section) }}</option>
                        @endforeach
                    </select>
                    @error('content_block_section')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium" for="content_block_status">Status</label>
                    <select wire:model="content_block_status" id="content_block_status" class="w-full p-2 border border-gray-300 rounded">
                         @foreach ( \App\Models\ContentBlock::STATUSES as $status )
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('content_block_status')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium" for="navigation_link_id">Associated Navigation link</label>
                    <select wire:model="navigation_link_id" id="navigation_link_id" class="w-full p-2 border border-gray-300 rounded">
                         @foreach ( \App\Models\NavigationLink::all() as $link )
                            <option value="{{ $link->id }}">{{ ucfirst($link->link_name) }}</option>
                        @endforeach
                    </select>
                    @error('navigation_link_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    @if ($editing_content_block_id)
                        <flux:button type="button" color="red" wire:click="cancel_edit" variant="danger">
                            Cancel
                        </flux:button>
                    @endif

                    <flux:button variant="primary" color="green" type="submit">
                        {{ $editing_content_block_id ? __('Update') : __('Create') }}
                    </flux:button>
                </div>

            </form>

        </div>

    </div>

</div>
