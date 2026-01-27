<div>
    @foreach ( $links as $link)
        @php
            $href= $link->link_route && Route::has($link->link_route) ? route($link->link_route) : "#";
            $current= $link->link_route && Route::has($link->link_route) && request()->routeIs($link->link_route) ? true : false;
        @endphp

        <flux:navlist.item
            icon="{{ $link->link_icon }}"
            :href="$href"
            :current="$current"
            wire:navigate
        >{{ __($link->link_name) }}</flux:navlist.item>
    @endforeach

</div>
