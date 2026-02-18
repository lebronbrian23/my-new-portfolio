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
                        <th class="border border-gray-300 px-2 py-1">Image</th>
                        <th class="border border-gray-300 px-2 py-1">Title</th>
                        <th class="border border-gray-300 px-2 py-1">Description</th>
                        <th class="border border-gray-300 px-2 py-1">Skills</th>
                        <th class="border border-gray-300 px-2 py-1">Project Url</th>
                        <th class="border border-gray-300 px-2 py-1">Is Api</th>
                        <th class="border border-gray-300 px-2 py-1" colspan="2">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($works as $work)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800">
                            <td class="border border-gray-300 px-2 py-1">{{ $work->id }}</td>
                            <td class="border border-gray-300 px-2 py-1">
                                @if( $work->image)
                                    <img src="{{ asset('storage/'.$work->image->url) }}" alt="{{ $work->title }}" class="h-16 w-16 object-cover rounded">
                                @endif
                            </td>
                            <td class="border border-gray-300 px-2 py-1">{{ $work->title }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $work->description }}</td>
                            <td class="border border-gray-300 px-2 py-1">
                                @foreach ( $work->skills as $skill )
                                    <span class="inline-block px-2 py-1 rounded-full mr-1 mb-1 space-x-1">{{ $skill->name }}<span>
                                @endforeach
                            </td>
                            <td class="border border-gray-300 px-2 py-1">{{ $work->url }}</td>

                            <td class="border border-gray-300 px-2 py-1">{{ $work->is_api ? 'Yes' : 'No' }}</td>

                            <td class="border border-gray-300 px-2 py-1">
                                <flux:button
                                    wire:click="edit({{ $work->id }})"
                                    class="text-blue-600 hover:underline"
                                    icon="pencil"
                                >
                                    Edit
                                </flux:button>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <flux:button variant="danger" color="red"
                                    wire:click="delete({{ $work->id }})"
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
            {{ $works->links() }}
        </div>

        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <h3 class="text-xl font-semibold mb-4">{{ __('Add / Edit Works') }}</h3>

            <form wire:submit.prevent="save" action="">

                <div class="mb-2">
                    <flux:textarea
                        label="Title"
                        placeholder="Enter work title here."
                        wire:model="title"
                        id="title"
                    />
                    @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <flux:textarea
                        label="Description"
                        placeholder="Enter work description here."
                        wire:model="description"
                        id="description"
                    />
                    @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <flux:input
                        label="Project URL"
                        placeholder="Enter project URL here."
                        wire:model="url"
                        id="url"
                    />
                    @error('url') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <flux:checkbox label="Is this an API Project?" wire:model="is_api" id="is_api" />
                    @error('is_api') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                @if( $editing_work_id && $current_photo)
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

                <flux:checkbox.group wire:model="skills" label="Skills">
                    @foreach ( \App\Models\Skill::all() as $skill )
                        <flux:checkbox label="{{ $skill->name }}" value="{{ $skill->id }}" />
                    @endforeach
                </flux:checkbox.group>


                <div class="flex justify-end gap-4">
                    @if ($editing_work_id)
                        <flux:button type="button" color="red" wire:click="cancel_edit" variant="danger">
                            Cancel
                        </flux:button>
                    @endif

                    <flux:button variant="primary" color="green" type="submit">
                        {{ $editing_work_id ? __('Update') : __('Create') }}
                    </flux:button>
                </div>

            </form>

        </div>

    </div>

</div>
