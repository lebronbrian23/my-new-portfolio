<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavigationLinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\NavigationLink::create([
            'link_name' => 'Home',
            'link_route' => 'home',
            'link_icon' => 'bolt',
            'link_position' => 1,
            'link_location' => 'header',
            'user_id' => User::first()->id ?? 1,
            'shows_on_frontend' => true
        ]);

        \App\Models\NavigationLink::create([
            'link_name' => 'Navigation Links',
            'link_route' => 'navigation-links',
            'link_icon' => 'bolt',
            'link_position' => 2,
            'link_location' => 'header',
            'user_id' => User::first()->id ?? 1,
            'shows_on_frontend' => true
        ]);

        \App\Models\NavigationLink::create([
            'link_name' => 'Content Blocks',
            'link_route' => 'content-blocks',
            'link_icon' => 'bolt',
            'link_position' => 3,
            'link_location' => 'header',
            'user_id' => User::first()->id ?? 1,
            'shows_on_frontend' => true
        ]);

    }
}
