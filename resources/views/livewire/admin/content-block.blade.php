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
                        <th class="border border-gray-300 px-2 py-1">File / Image</th>
                        <th class="border border-gray-300 px-2 py-1">Title</th>
                        <th class="border border-gray-300 px-2 py-1">Description</th>
                        <th class="border border-gray-300 px-2 py-1">Years of Experience</th>
                        <th class="border border-gray-300 px-2 py-1">Projects Completed
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
                                @if( $content_block->photo)
                                    @if($content_block->content_block_section === 'resume')
                                        <a href="{{ asset('storage/'.$content_block->photo) }}" target="_blank" class="text-blue-600 underline">PDF</a>
                                    @else
                                        <img src="{{ asset('storage/'.$content_block->photo) }}" alt="{{ $content_block->title }}" class="h-16 w-16 object-cover rounded">
                                    @endif
                                @endif
                            </td>
                            <td class="border border-gray-300 px-2 py-1">{{ $content_block->title }}</td>
                            <td class="border border-gray-300 px-2 py-1">
                                <div class="max-w-xs truncate">{!! Str::limit(strip_tags($content_block->description), 50) !!}</div>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">{{ $content_block->years_of_experience }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $content_block->projects_completed }}</td>
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

                <div class="mb-4">
                    <flux:input
                        type="text"
                        label="Title"
                        placeholder="Enter title here"
                        wire:model="title"
                    />
                    @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200" for="description">
                        Description
                    </label>
                    <x-trix-input
                        id="description"
                        name="description"
                        wire:model.live="description"
                        :value="$description"
                    />
                    @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200" for="content_block_section">
                        Section
                    </label>
                    <select
                        wire:model="content_block_section"
                        wire:change="$refresh"
                        id="content_block_section"
                        class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Select a section</option>
                        @foreach ( \App\Models\ContentBlock::SECTIONS as $section )
                            <option value="{{ $section }}">{{ ucfirst($section) }}</option>
                        @endforeach
                    </select>
                    @error('content_block_section')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                @if( $editing_content_block_id && $current_photo)
                    <div class="mb-4">
                        <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200">
                            Current @if($content_block_section === 'resume') file @else image @endif
                        </label>
                        <div class="mt-2">
                            @if($content_block_section === 'resume')
                                <a href="{{ asset('storage/'.$current_photo) }}" target="_blank" class="text-blue-600 underline">Download PDF</a>
                            @else
                                <img src="{{ asset('storage/'.$current_photo) }}" alt="Current Photo" class="rounded w-32 h-32 object-cover">
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200" for="photo">
                        @if($content_block_section === 'resume')
                            File
                        @else
                            Image
                        @endif
                        {{ $editing_content_block_id ? '(Upload new to replace)' : '' }}
                    </label>
                    <input
                        type="file"
                        wire:model="photo"
                        id="photo"
                        accept="@if($content_block_section === 'resume') application/pdf @else image/png, image/jpeg, image/jpg @endif"
                        class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-blue-500"
                    >
                    @error('photo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                    <div wire:loading wire:target='photo' class="mt-2">
                        <span class="text-blue-500 text-sm">Uploading...</span>
                    </div>
                </div>

                @if($photo && method_exists($photo, 'temporaryUrl'))
                    <div class="mb-4">
                        <p class="font-medium mb-2 text-gray-700 dark:text-gray-200">Preview:</p>
                        @if($content_block_section === 'resume')
                            <a href="{{ $photo->temporaryUrl() }}" target="_blank" class="text-blue-600 underline">Open PDF</a>
                        @else
                            <img src="{{ $photo->temporaryUrl() }}" alt="Photo Preview" class="rounded w-32 h-32 object-cover">
                        @endif
                    </div>
                @endif

                @if($content_block_section === 'home')
                    <div class="mb-4">
                        <flux:input
                            type="number"
                            label="Years of Experience."
                            placeholder="Enter years of experience."
                            wire:model="years_of_experience"
                        />
                        @error('years_of_experience') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <flux:input
                            type="number"
                            label="Projects Completed."
                            placeholder="Enter number of projects completed."
                            wire:model="projects_completed"
                        />
                        @error('projects_completed') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif


                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200" for="content_block_status">
                        Status
                    </label>
                    <select
                        wire:model="content_block_status"
                        id="content_block_status"
                        class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Select status</option>
                        @foreach ( \App\Models\ContentBlock::STATUSES as $status )
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('content_block_status')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200" for="navigation_link_id">
                        Associated Navigation Link
                    </label>
                    <select
                        wire:model="navigation_link_id"
                        id="navigation_link_id"
                        class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Select a navigation link</option>
                        @foreach ( \App\Models\NavigationLink::select('id','link_name',)
                                ->whereNotIn('link_name',['Content Blocks', 'Navigation Links'])
                                ->where('link_status', 'active')
                                ->orderBy('link_position','asc')
                                ->get(); as $link )
                            <option value="{{ $link->id }}">{{ ucfirst($link->link_name) }}</option>
                        @endforeach
                    </select>
                    @error('navigation_link_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-4 mt-6">
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
