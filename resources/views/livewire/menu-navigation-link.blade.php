<div>
    @foreach ( $links as $link)
        <flux:navlist.item icon="{{ $link->link_icon }}" :href="route($link->link_route)" :current="request()->routeIs($link->link_route)" wire:navigate>{{ __($link->link_name) }}</flux:navlist.item>
    @endforeach

</div>
