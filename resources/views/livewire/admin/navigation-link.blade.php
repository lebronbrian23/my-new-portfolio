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

            <table class="border-collapse border border-gray-400 w-full min-w-max">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">#</th>
                        <th class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">Name</th>
                        <th class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">Route</th>
                        <th class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">Icon</th>
                        <th class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">Location</th>
                        <th class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">Position</th>
                        <th class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">Shows on frontend</th>
                        <th class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">Status</th>
                        <th class="border border-gray-300 px-2 py-1 text-xs sm:text-sm" colspan="2">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($links as $link)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800">
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $link->id }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $link->link_name }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $link->link_route }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $link->link_icon }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $link->link_location }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">{{ $link->link_position }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">
                                <flux:badge size="sm" color="{{ $link->shows_on_frontend === 'yes' ? 'green' : 'red' }}">{{ $link->shows_on_frontend === 'yes' ? 'Yes' : 'No' }}</flux:badge>
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-xs sm:text-sm">
                                <flux:badge size="sm" color="{{ $link->link_status === 'active' ? 'green' : 'red' }}">{{ $link->link_status === 'active' ? 'Active' : 'Inactive' }}</flux:badge>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <flux:button
                                    wire:click="edit({{ $link->id }})"
                                    class="text-blue-600 hover:underline text-xs sm:text-sm"
                                    icon="pencil"
                                >
                                    Edit
                                </flux:button>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <flux:button variant="danger" color="red"
                                    wire:click="delete({{ $link->id }})"
                                    class="text-blue-600 hover:underline text-xs sm:text-sm"
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

        </div>

        <!-- Form Section - Responsive -->
        <div class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <h3 class="text-lg sm:text-xl font-semibold mb-4">{{ __('Add / Edit Navigation Link') }}</h3>

            <form wire:submit.prevent="save" action="">

                <div class="mb-2">
                    <label class="block mb-1 font-medium text-sm" for="link_name">Name</label>
                    <select wire:model="link_name" id="link_name" class="w-full p-2 border border-gray-300 rounded text-sm sm:text-base">
                        @foreach ( \App\Models\NavigationLink::ROUTE_NAMES as $route )
                            <option value="{{ ucfirst($route) }}">{{ ucfirst($route) }}</option>
                        @endforeach
                    </select>
                    @error('link_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label class="block mb-1 font-medium text-sm" for="link_route">Route</label>
                    <input type="text" wire:model="link_route" id="link_route" placeholder="link route" class="w-full p-2 border border-gray-300 rounded text-sm sm:text-base">
                    @error('link_route') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label class="block mb-1 font-medium text-sm" for="link_icon">Icon</label>
                    <input type="text" wire:model="link_icon" id="link_icon" placeholder="link icon" class="w-full p-2 border border-gray-300 rounded text-sm sm:text-base">
                    @error('link_icon') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label class="block mb-1 font-medium text-sm" for="link_location">Location</label>
                    <select wire:model="link_location" id="link_location" class="w-full p-2 border border-gray-300 rounded text-sm sm:text-base">
                        <option value="header">Header</option>
                        <option value="footer">Footer</option>
                    </select>
                    @error('link_location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label class="block mb-1 font-medium text-sm" for="link_position">Position on Menu</label>
                    <input type="number" wire:model="link_position" id="link_position" placeholder="link position" class="w-full p-2 border border-gray-300 rounded text-sm sm:text-base">
                    @error('link_position') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium text-sm" for="link_status">Status</label>
                    <select wire:model="link_status" id="link_status" class="w-full p-2 border border-gray-300 rounded text-sm sm:text-base">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('link_status')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium text-sm" for="shows_on_frontend">Shows on Frontend</label>
                    <select wire:model="shows_on_frontend" id="shows_on_frontend" class="w-full p-2 border border-gray-300 rounded text-sm sm:text-base">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                    @error('shows_on_frontend')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-4">
                    @if ($editing_link_id)
                        <flux:button type="button" color="red" wire:click="cancel_edit" variant="danger" class="w-full sm:w-auto">
                            Cancel
                        </flux:button>
                    @endif

                    <flux:button variant="primary" color="green" type="submit" class="w-full sm:w-auto">
                        {{ $editing_link_id ? __('Update') : __('Create') }}
                    </flux:button>
                </div>

            </form>

        </div>

    </div>

</div>
