<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800 flex flex-col">

    <!-- Main Wrapper -->
    <div class="flex flex-1 overflow-hidden">

        <!-- Sidebar -->
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 w-64 flex-shrink-0">
            <!-- Mobile toggle -->
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 rtl:space-x-reverse p-4" wire:navigate>
                <x-app-logo />
            </a>

            <!-- Navigation -->
            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:navlist.item>

                    <livewire:menu-navigation-link />
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:navlist.item>
                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            @auth
            <flux:dropdown class="hidden lg:block mt-auto mb-4" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />
                <flux:menu class="w-[220px]">
                    <!-- User Info -->
                    <div class="p-2 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                {{ auth()->user()->initials() }}
                            </span>
                            <div class="flex flex-col truncate">
                                <span class="font-semibold truncate">{{ auth()->user()->name }}</span>
                                <span class="text-xs truncate">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                    <flux:menu.separator />
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
            @endauth
        </flux:sidebar>

        <!-- Content Area -->
        <div class="flex-1 overflow-auto flex flex-col">
            <!-- Mobile Header -->
            @auth
            <flux:header class="lg:hidden flex items-center border-b border-zinc-200 dark:border-zinc-700 px-4 py-2">
                <flux:sidebar.toggle icon="bars-2" inset="left" />
                <flux:spacer />
                <flux:dropdown position="top" align="end">
                    <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />
                    <flux:menu>
                        <div class="p-2 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                                <div class="flex flex-col truncate">
                                    <span class="font-semibold truncate">{{ auth()->user()->name }}</span>
                                    <span class="text-xs truncate">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <flux:menu.separator />
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </flux:header>
            @endauth

            <!-- Main Content Slot -->
            <main class="p-6 w-full max-w-7xl mx-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @fluxScripts
</body>
</html>
