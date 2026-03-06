<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if ( \App\Models\User::count() === 0 ) {
            $this->call(UserTableSeeder::class);
        }

        if ( \App\Models\NavigationLink::count() === 0 ) {
            $this->call(NavigationLinkTableSeeder::class);
        }

        if ( \App\Models\ContentBlock::count() === 0 ) {
            $this->call(ContentBlockTableSeeder::class);
        }

    }
}
